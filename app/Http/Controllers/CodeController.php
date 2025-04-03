<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function index()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $codes = collect([]);

        return view('codes.index', compact('codes'));
    }

    public function create()
    {
        return view('codes.create');
    }

    public function store(Request $request)
    {
        // Validasyon ve kayıt işlemleri burada yapılacak
        return redirect()->route('codes.index')->with('success', 'Kod başarıyla oluşturuldu.');
    }
} 