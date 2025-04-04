<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $users = collect([]);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validasyon ve kayıt işlemleri burada yapılacak
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    public function account()
    {
        // Giriş yapmış kullanıcının bilgilerini al
        $user = auth()->user();
        return view('users.account', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        // Validasyon ve güncelleme işlemleri burada yapılacak
        return redirect()->route('users.account')->with('success', 'Hesap bilgileri başarıyla güncellendi.');
    }
} 