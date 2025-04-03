<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function general()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $settings = collect([]);
        
        return view('settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        // Validasyon ve güncelleme işlemleri burada yapılacak
        return redirect()->route('settings.general')->with('success', 'Genel ayarlar başarıyla güncellendi.');
    }

    public function desiPrices()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $desiPrices = collect([]);
        
        return view('settings.desi-prices', compact('desiPrices'));
    }

    public function updateDesiPrices(Request $request)
    {
        // Validasyon ve güncelleme işlemleri burada yapılacak
        return redirect()->route('settings.desi-prices')->with('success', 'Desi fiyatları başarıyla güncellendi.');
    }

    public function parameters()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $parameters = collect([]);
        
        return view('settings.parameters', compact('parameters'));
    }

    public function updateParameters(Request $request)
    {
        // Validasyon ve güncelleme işlemleri burada yapılacak
        return redirect()->route('settings.parameters')->with('success', 'Parametreler başarıyla güncellendi.');
    }

    public function surveys()
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $surveys = collect([]);
        
        return view('settings.surveys', compact('surveys'));
    }

    public function updateSurveys(Request $request)
    {
        // Validasyon ve güncelleme işlemleri burada yapılacak
        return redirect()->route('settings.surveys')->with('success', 'Anket başarıyla güncellendi.');
    }
} 