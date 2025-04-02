<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create()
    {
        $dealers = Dealer::all();
        return view('messages.create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dealer_id' => 'required|exists:dealers,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'send_as_email' => 'boolean'
        ]);

        $message = Message::create([
            'dealer_id' => $validated['dealer_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'sender_id' => auth()->id(),
            'is_sent_as_email' => $request->has('send_as_email')
        ]);

        // Email gönderme işlemi burada yapılacak
        if ($request->has('send_as_email')) {
            // Mail gönderme kodu buraya gelecek
        }

        return redirect()->route('messages.sent')
            ->with('success', 'Mesaj başarıyla gönderildi.');
    }

    public function inbox(Request $request)
    {
        $query = Message::with(['dealer', 'sender'])
            ->where('receiver_id', auth()->id());

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dealer', function($q) use ($search) {
                    $q->where('company_title', 'like', "%{$search}%");
                })
                ->orWhere('subject', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('messages.inbox', compact('messages'));
    }

    public function sent(Request $request)
    {
        $query = Message::with(['dealer', 'receiver'])
            ->where('sender_id', auth()->id());

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dealer', function($q) use ($search) {
                    $q->where('company_title', 'like', "%{$search}%");
                })
                ->orWhere('subject', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('messages.sent', compact('messages'));
    }

    public function markAsRead(Message $message)
    {
        if ($message->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function show(Message $message)
    {
        if ($message->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'subject' => $message->subject,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'dealer' => $message->dealer->company_title,
            'created_at' => $message->created_at->format('d.m.Y H:i'),
        ]);
    }

    public function destroy(Message $message)
    {
        if ($message->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();
        return response()->json(['success' => true]);
    }
} 