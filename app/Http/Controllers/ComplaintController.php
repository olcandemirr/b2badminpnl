<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Dealer;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create()
    {
        $dealers = Dealer::all();
        return view('complaints.create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dealer_id' => 'required|exists:dealers,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Bayinin sahibi olan kullanıcıyı bulalım
        $dealer = Dealer::findOrFail($validated['dealer_id']);
        $receiverId = null; // Varsayılan olarak null

        // Eğer bayinin temsilcisi varsa onu alıcı olarak belirleyelim
        if (!empty($dealer->representative)) {
            $receiverId = $dealer->representative;
        }

        $complaint = Complaint::create([
            'dealer_id' => $validated['dealer_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'status' => 'open'
        ]);

        return redirect()->route('complaints.sent')
            ->with('success', 'Şikayet başarıyla kaydedildi.');
    }

    public function inbox(Request $request)
    {
        $query = Complaint::with(['dealer', 'sender'])
            ->where('receiver_id', auth()->id());

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dealer', function($q) use ($search) {
                    $q->where('company_title', 'like', "%{$search}%");
                })
                ->orWhere('subject', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $complaints = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('complaints.inbox', compact('complaints'));
    }

    public function sent(Request $request)
    {
        $query = Complaint::with(['dealer', 'receiver'])
            ->where('sender_id', auth()->id());

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dealer', function($q) use ($search) {
                    $q->where('company_title', 'like', "%{$search}%");
                })
                ->orWhere('subject', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $complaints = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('complaints.sent', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        // Gelen veya giden şikayetleri görüntülemek için yetki kontrolü
        if ($complaint->receiver_id !== auth()->id() && $complaint->sender_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $dealerName = $complaint->dealer ? $complaint->dealer->company_title : 'Belirtilmemiş';
        $senderName = $complaint->sender ? $complaint->sender->name : 'Belirtilmemiş';
        $receiverName = $complaint->receiver ? $complaint->receiver->name : 'Belirtilmemiş';
        $resolverName = $complaint->resolver ? $complaint->resolver->name : null;

        // Alıcı kullanıcısı şikayeti görüntülediğinde okundu olarak işaretle
        if ($complaint->receiver_id === auth()->id() && !$complaint->is_read) {
            $complaint->update(['is_read' => true]);
        }

        return response()->json([
            'subject' => $complaint->subject,
            'description' => $complaint->description,
            'sender' => $senderName,
            'receiver' => $receiverName,
            'dealer' => $dealerName,
            'status' => $complaint->status,
            'resolution' => $complaint->resolution,
            'resolved_at' => $complaint->resolved_at ? $complaint->resolved_at->format('d.m.Y H:i') : null,
            'resolver' => $resolverName,
            'created_at' => $complaint->created_at->format('d.m.Y H:i'),
        ]);
    }

    public function markAsRead(Complaint $complaint)
    {
        if ($complaint->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $complaint->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, Complaint $complaint)
    {
        // Alıcı veya gönderen kullanıcı değilse yetki kontrolü
        if ($complaint->receiver_id !== auth()->id() && $complaint->sender_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:open,in-progress,closed',
            'resolution' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        // Eğer durum kapatıldıysa, çözüm ve çözüm tarihi bilgilerini ekle
        if ($validated['status'] === 'closed') {
            $updateData['resolution'] = $validated['resolution'];
            $updateData['resolved_at'] = now();
            $updateData['resolved_by'] = auth()->id();
        }

        $complaint->update($updateData);

        return response()->json(['success' => true]);
    }

    public function destroy(Complaint $complaint)
    {
        // Gelen veya giden şikayetleri silebilmek için yetki kontrolü
        if ($complaint->receiver_id !== auth()->id() && $complaint->sender_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $complaint->delete();
        return response()->json(['success' => true]);
    }
}
