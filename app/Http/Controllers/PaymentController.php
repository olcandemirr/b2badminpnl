<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function bankAccounts()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $accounts = collect([]);
        
        return view('payments.bank-accounts', compact('accounts'));
    }

    public function createBankAccount()
    {
        return view('payments.create-bank-account');
    }

    public function storeBankAccount(Request $request)
    {
        // Validasyon ve kayıt işlemleri burada yapılacak
        return redirect()->route('payments.bank-accounts')->with('success', 'Havale hesabı başarıyla eklendi.');
    }

    public function virtualPos()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $virtualPos = collect([]);
        
        return view('payments.virtual-pos', compact('virtualPos'));
    }

    public function createVirtualPos()
    {
        return view('payments.create-virtual-pos');
    }

    public function storeVirtualPos(Request $request)
    {
        // Validasyon ve kayıt işlemleri burada yapılacak
        return redirect()->route('payments.virtual-pos')->with('success', 'Sanal pos başarıyla eklendi.');
    }

    public function virtualPosPayments()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $payments = collect([]);
        
        return view('payments.virtual-pos-payments', compact('payments'));
    }
} 