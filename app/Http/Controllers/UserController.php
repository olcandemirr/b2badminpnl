<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Arama filtresi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        // Sıralama
        $orderBy = $request->order_by ?? 'id';
        $orderDir = $request->order_dir ?? 'desc';
        
        $query->orderBy($orderBy, $orderDir);

        // Sayfalama
        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required|in:admin,customer,dealer,staff',
            'full_name' => 'required|string|max:255',
        ]);

        try {
            // Kullanıcı verilerini hazırla
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'full_name' => $request->full_name,
                'status' => $request->has('status') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Veritabanına doğrudan ekle
            DB::table('users')->insert($userData);
            
            return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Kullanıcı oluşturulurken hata oluştu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'user_type' => 'required|in:admin,customer,dealer,staff',
            'full_name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->full_name = $request->full_name;
        $user->status = $request->has('status');
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Admin kullanıcıları silinemesin
        if ($user->user_type === 'admin' && User::where('user_type', 'admin')->count() <= 1) {
            return response()->json(['success' => false, 'message' => 'Son admin kullanıcısı silinemez.']);
        }
        
        $user->delete();
        
        return response()->json(['success' => true, 'message' => 'Kullanıcı başarıyla silindi.']);
    }

    public function account()
    {
        // Giriş yapmış kullanıcının bilgilerini al
        $user = auth()->user();
        return view('users.account', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
        ]);

        $user->email = $request->email;
        $user->full_name = $request->full_name;
        
        if ($request->filled('current_password') && $request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Mevcut şifre doğru değil.']);
            }
            
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('users.account')->with('success', 'Hesap bilgileri başarıyla güncellendi.');
    }
    
    public function export()
    {
        $users = User::all();
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="kullanicilar_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            // BOM (Byte Order Mark) ekleyelim - UTF-8 için
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Başlıklar
            fputcsv($file, [
                'ID',
                'Kullanıcı Adı',
                'E-posta',
                'Ad Soyad',
                'Kullanıcı Tipi',
                'Durum',
                'Oluşturma Tarihi'
            ], ';');

            // Veriler
            foreach ($users as $user) {
                $row = [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->full_name,
                    $user->user_type_text,
                    $user->status_text,
                    $user->created_at->format('d.m.Y H:i')
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}