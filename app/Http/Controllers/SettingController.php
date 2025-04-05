<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        // Tüm ayarları veritabanından getir
        $settings = Setting::getAllSettings();
        
        return view('settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        // Logo yükleme işlemi
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logoPath = $request->file('logo')->store('public/settings');
            Setting::set('logo', str_replace('public/', '', $logoPath), 'general', 'file', true, 'Site logosu');
        }
        
        if ($request->hasFile('logo_zil') && $request->file('logo_zil')->isValid()) {
            $logoZilPath = $request->file('logo_zil')->store('public/settings');
            Setting::set('logo_zil', str_replace('public/', '', $logoZilPath), 'general', 'file', true, 'Site zil logosu');
        }
        
        // Genel site bilgileri
        $siteSettings = [
            'site_name' => $request->site_name,
            'site_name_en' => $request->site_name_en, 
            'site_description' => $request->site_description,
            'site_description_en' => $request->site_description_en,
            'head_code' => $request->head_code,
            'body_code' => $request->body_code,
        ];
        
        // Firma bilgileri
        $companySettings = [
            'company_name' => $request->company_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'phone1' => $request->phone1,
            'whatsapp' => $request->whatsapp,
            'website' => $request->website,
            'system_email' => $request->system_email,
            'other_emails' => $request->other_emails,
            'dealer_email' => $request->dealer_email,
            'infrastructure_email' => $request->infrastructure_email,
            'order_mail_message' => $request->order_mail_message,
        ];
        
        // Mail sunucu ayarları
        $mailSettings = [
            'mail_server' => $request->mail_server,
            'mail_port' => $request->mail_port,
            'mail_password' => $request->mail_password,
            'ssl_enabled' => $request->has('ssl_enabled'),
        ];
        
        // Sosyal medya ayarları
        $socialSettings = [
            'facebook_page' => $request->facebook_page,
            'twitter_page' => $request->twitter_page,
            'instagram_page' => $request->instagram_page,
            'linkedin_page' => $request->linkedin_page,
        ];
        
        // Stok ayarları
        $stockSettings = [
            'kdv_included' => $request->has('kdv_included'),
            'kdv_rate' => $request->kdv_rate,
            'stock_control' => $request->has('stock_control'),
            'show_available' => $request->has('show_available'),
            'show_all_products' => $request->has('show_all_products'),
            'product_photo_preview' => $request->has('product_photo_preview'),
        ];
        
        // Sipariş ayarları
        $orderSettings = [
            'min_order_amount' => $request->min_order_amount,
            'min_order_currency' => $request->min_order_currency,
            'free_shipping_amount' => $request->free_shipping_amount,
            'free_shipping_currency' => $request->free_shipping_currency,
            'credit_card_discount' => $request->credit_card_discount,
            'bank_transfer_discount' => $request->bank_transfer_discount,
            'mail_order_discount' => $request->mail_order_discount,
            'check_only_payment' => $request->check_only_payment,
        ];
        
        // Ödeme seçenekleri
        $paymentSettings = [
            'cash_payment' => $request->has('cash_payment'),
            'credit_card' => $request->has('credit_card'),
            'eft_transfer' => $request->has('eft_transfer'),
            'pay_at_door' => $request->has('pay_at_door'),
            'mail_order' => $request->has('mail_order'),
            'payment_note' => $request->payment_note,
        ];
        
        // Tüm ayarları güncelle
        foreach ($siteSettings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'general', 'text', true);
            }
        }
        
        foreach ($companySettings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'company', 'text', true);
            }
        }
        
        foreach ($mailSettings as $key => $value) {
            if ($value !== null) {
                $type = ($key === 'ssl_enabled') ? 'boolean' : 'text';
                Setting::set($key, $value, 'mail', $type, false);
            }
        }
        
        foreach ($socialSettings as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'social', 'text', true);
            }
        }
        
        foreach ($stockSettings as $key => $value) {
            $type = in_array($key, ['kdv_rate']) ? 'number' : 'boolean';
            Setting::set($key, $value, 'stock', $type, true);
        }
        
        foreach ($orderSettings as $key => $value) {
            if ($value !== null) {
                $type = in_array($key, ['min_order_currency', 'free_shipping_currency']) ? 'text' : 'number';
                Setting::set($key, $value, 'order', $type, true);
            }
        }
        
        foreach ($paymentSettings as $key => $value) {
            $type = ($key === 'payment_note') ? 'text' : 'boolean';
            Setting::set($key, $value, 'payment', $type, true);
        }
        
        return redirect()->route('settings.general')->with('success', 'Genel ayarlar başarıyla güncellendi.');
    }

    public function desiPrices()
    {
        // Desi fiyatlarını getir
        $desiPrices = [];
        for ($i = 1; $i <= 30; $i++) {
            $key = 'desi_price_' . $i;
            $desiPrices[$i] = Setting::get($key, 0);
        }
        
        return view('settings.desi-prices', compact('desiPrices'));
    }

    public function updateDesiPrices(Request $request)
    {
        // Desi fiyatlarını güncelle
        $desiPrices = $request->validate([
            'desi_prices' => 'required|array',
            'desi_prices.*' => 'required|numeric|min:0'
        ]);
        
        foreach ($desiPrices['desi_prices'] as $desi => $price) {
            $key = 'desi_price_' . $desi;
            Setting::set($key, $price, 'shipping', 'number', true, 'Desi ' . $desi . ' fiyatı');
        }
        
        return redirect()->route('settings.desi-prices')->with('success', 'Desi fiyatları başarıyla güncellendi.');
    }

    public function parameters()
    {
        // Parametreleri getir
        $parameters = Setting::getAllSettings('parameters');
        
        return view('settings.parameters', compact('parameters'));
    }

    public function updateParameters(Request $request)
    {
        // Parametreleri güncelle
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'parameters', 'text', true);
            }
        }
        
        return redirect()->route('settings.parameters')->with('success', 'Parametreler başarıyla güncellendi.');
    }

    public function surveys()
    {
        // Anket ayarlarını ve seçenekleri getir
        $settings = Setting::getAllSettings('survey');
        $surveyOptions = \App\Models\SurveyOption::orderBy('order')->get();
        
        return view('settings.surveys', compact('settings', 'surveyOptions'));
    }

    public function updateSurveys(Request $request)
    {
        // Anket başlığını güncelle
        Setting::set('survey_title', $request->survey_title, 'survey', 'text', true, 'Anket başlığı');
        Setting::set('survey_title_en', $request->survey_title_en, 'survey', 'text', true, 'Anket başlığı (İngilizce)');
        Setting::set('survey_active', $request->has('survey_active'), 'survey', 'boolean', true, 'Anket aktif mi?');
        
        return redirect()->route('settings.surveys')->with('success', 'Anket ayarları başarıyla güncellendi.');
    }

    public function addSurveyOption(Request $request)
    {
        $request->validate([
            'option' => 'required|string|max:255',
            'option_en' => 'nullable|string|max:255',
        ]);
        
        // Maksimum sıra değerini bul
        $maxOrder = \App\Models\SurveyOption::max('order') ?? 0;
        
        // Yeni seçeneği ekle
        \App\Models\SurveyOption::create([
            'option' => $request->option,
            'option_en' => $request->option_en,
            'order' => $maxOrder + 1,
        ]);
        
        return redirect()->route('settings.surveys')->with('success', 'Anket seçeneği başarıyla eklendi.');
    }

    public function updateSurveyOption(Request $request, $id)
    {
        $request->validate([
            'option' => 'required|string|max:255',
            'option_en' => 'nullable|string|max:255',
        ]);
        
        $option = \App\Models\SurveyOption::findOrFail($id);
        $option->update([
            'option' => $request->option,
            'option_en' => $request->option_en,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('settings.surveys')->with('success', 'Anket seçeneği başarıyla güncellendi.');
    }

    public function deleteSurveyOption($id)
    {
        $option = \App\Models\SurveyOption::findOrFail($id);
        $option->delete();
        
        return redirect()->route('settings.surveys')->with('success', 'Anket seçeneği başarıyla silindi.');
    }

    public function reorderSurveyOptions(Request $request)
    {
        $ids = $request->ids;
        
        foreach ($ids as $order => $id) {
            \App\Models\SurveyOption::where('id', $id)->update(['order' => $order + 1]);
        }
        
        return response()->json(['success' => true]);
    }
} 