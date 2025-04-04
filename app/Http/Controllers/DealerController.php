<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DealerController extends Controller
{
    public function index(Request $request)
    {
        $query = Dealer::query();

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('dealer_no', 'like', "%{$search}%")
                  ->orWhere('company_title', 'like', "%{$search}%")
                  ->orWhere('dealer_type', 'like', "%{$search}%")
                  ->orWhere('main_dealer', 'like', "%{$search}%");
            });
        }

        // Dealer type filtresi
        if ($request->filled('dealer_type')) {
            $query->where('dealer_type', $request->dealer_type);
        }
        
        // Super Dealer filtresi
        if ($request->has('is_super_dealer')) {
            $query->where('is_super_dealer', true);
        }

        $dealers = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'dealers' => $dealers
            ]);
        }

        // İstatistikler
        $stats = [
            'anaBayi' => Dealer::where('dealer_type', 'Ana Bayi')->count(),
            'altBayi' => Dealer::where('dealer_type', 'Alt Bayi')->count(),
            'superDealer' => Dealer::where('is_super_dealer', true)->count(),
        ];

        return view('dealers.index', compact('dealers', 'stats'));
    }

    public function exportExcel(Request $request)
    {
        // Excel dışa aktarma işlemi için CSV formatında basit bir çözüm
        $query = Dealer::query();

        // Arama filtresi uygula
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('dealer_no', 'like', "%{$search}%")
                  ->orWhere('company_title', 'like', "%{$search}%")
                  ->orWhere('dealer_type', 'like', "%{$search}%")
                  ->orWhere('main_dealer', 'like', "%{$search}%");
            });
        }

        // Dealer type filtresi
        if ($request->filled('dealer_type')) {
            $query->where('dealer_type', $request->dealer_type);
        }
        
        // Super Dealer filtresi
        if ($request->has('is_super_dealer')) {
            $query->where('is_super_dealer', true);
        }

        $dealers = $query->get();
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="bayiler_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($dealers) {
            $file = fopen('php://output', 'w');
            // BOM (Byte Order Mark) ekleyelim - UTF-8 için
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Başlıklar
            fputcsv($file, [
                'ID',
                'Bayi No',
                'Ünvan',
                'Kullanıcı Adı',
                'E-posta',
                'Bayi Tipi',
                'Super Dealer',
                'Ana Bayi',
                'Telefon',
                'Adres',
                'Şehir',
                'İlçe',
                'Durumu'
            ], ';');

            // Veriler
            foreach ($dealers as $dealer) {
                $row = [
                    $dealer->id,
                    $dealer->dealer_no,
                    $dealer->company_title,
                    $dealer->username,
                    $dealer->email,
                    $dealer->dealer_type,
                    $dealer->is_super_dealer ? 'Evet' : 'Hayır',
                    $dealer->main_dealer,
                    $dealer->phone,
                    $dealer->address,
                    $dealer->city,
                    $dealer->district,
                    $dealer->is_active ? 'Aktif' : 'Pasif',
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dealer_type' => 'required|in:Ana Bayi,Alt Bayi',
            'username' => 'required|unique:dealers',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:dealers',
            'program_code' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_title' => 'required',
            'country' => 'required',
            'city' => 'required',
            'district' => 'required',
            'postal_code' => 'nullable',
            'address_title' => 'nullable',
            'address' => 'required',
            'address_description' => 'nullable',
            'phone' => 'required',
            'tax_office' => 'nullable',
            'tax_number' => 'nullable',
            'tax_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'signature_circular' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'trade_registry' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'findeks_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'balance' => 'nullable|numeric',
            'order_limit' => 'nullable|numeric',
            'yearly_target' => 'nullable|numeric',
            'representative' => 'nullable',
            'language' => 'required|in:Türkçe,English',
            'currency' => 'required|in:TRY,USD,EUR',
            'price_type' => 'required|in:perakende,toptan',
            'general_discount' => 'nullable|numeric|min:0|max:100',
            'additional_discount' => 'nullable|numeric|min:0|max:100',
            'extra_discount' => 'nullable|numeric|min:0|max:100',
            'discount_profile' => 'nullable',
            'main_dealer' => 'nullable|required_if:dealer_type,Alt Bayi',
        ]);

        try {
            // Bayi numarası oluştur: "B" + random 5 karakter
            $dealerNo = 'B' . strtoupper(Str::random(5));
            while (Dealer::where('dealer_no', $dealerNo)->exists()) {
                $dealerNo = 'B' . strtoupper(Str::random(5));
            }
            
            // Yeni bayi oluştur
            $dealer = new Dealer();
            $dealer->dealer_no = $dealerNo;
            $dealer->dealer_type = $validated['dealer_type'];
            $dealer->is_super_dealer = $request->has('is_super_dealer');
            $dealer->username = $validated['username'];
            $dealer->password = Hash::make($validated['password']);
            $dealer->email = $validated['email'];
            $dealer->program_code = $validated['program_code'] ?? null;
            $dealer->is_active = $request->has('is_active');
            
            $dealer->first_name = $validated['first_name'];
            $dealer->last_name = $validated['last_name'];
            $dealer->company_title = $validated['company_title'];
            $dealer->country = $validated['country'];
            $dealer->city = $validated['city'];
            $dealer->district = $validated['district'];
            $dealer->postal_code = $validated['postal_code'] ?? null;
            $dealer->address_title = $validated['address_title'] ?? null;
            $dealer->address = $validated['address'];
            $dealer->address_description = $validated['address_description'] ?? null;
            $dealer->phone = $validated['phone'];
            $dealer->tax_office = $validated['tax_office'] ?? null;
            $dealer->tax_number = $validated['tax_number'] ?? null;
            
            // Boolean alanları
            $dealer->has_debt_order_block = $request->has('has_debt_order_block');
            $dealer->has_free_payment = $request->has('has_free_payment');
            $dealer->cash_only = $request->has('cash_only');
            $dealer->card_payment = $request->has('card_payment');
            $dealer->check_payment = $request->has('check_payment');
            $dealer->cash_payment = $request->has('cash_payment');
            $dealer->pay_at_door = $request->has('pay_at_door');
            $dealer->include_vat = $request->has('include_vat');
            $dealer->campaign_news = $request->has('campaign_news');
            $dealer->contract = $request->has('contract');
            $dealer->kvkk = $request->has('kvkk');
            $dealer->separate_warehouse = $request->has('separate_warehouse');
            $dealer->gift_passive = $request->has('gift_passive');
            
            // Zorunluluk kontrol alanları
            $dealer->tax_document_required = $request->has('tax_document_required');
            $dealer->signature_circular_required = $request->has('signature_circular_required');
            $dealer->trade_registry_required = $request->has('trade_registry_required');
            $dealer->findeks_report_required = $request->has('findeks_report_required');
            
            // Diğer alanlar
            $dealer->main_dealer = $validated['main_dealer'] ?? null;
            $dealer->balance = $validated['balance'] ?? 0;
            $dealer->order_limit = $validated['order_limit'] ?? 0;
            $dealer->yearly_target = $validated['yearly_target'] ?? 0;
            $dealer->representative = $validated['representative'] ?? null;
            $dealer->language = $validated['language'];
            $dealer->currency = $validated['currency'];
            $dealer->price_type = $validated['price_type'];
            $dealer->general_discount = $validated['general_discount'] ?? 0;
            $dealer->additional_discount = $validated['additional_discount'] ?? 0;
            $dealer->extra_discount = $validated['extra_discount'] ?? 0;
            $dealer->discount_profile = $validated['discount_profile'] ?? null;

            // Dosya yüklemeleri
            if ($request->hasFile('tax_document')) {
                $dealer->tax_document = $request->file('tax_document')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('signature_circular')) {
                $dealer->signature_circular = $request->file('signature_circular')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('trade_registry')) {
                $dealer->trade_registry = $request->file('trade_registry')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('findeks_report')) {
                $dealer->findeks_report = $request->file('findeks_report')->store('dealer_documents', 'public');
            }

            $dealer->save();

            return redirect()->route('dealers.index')
                ->with('success', 'Bayi başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Bayi oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function create()
    {
        // Ana bayileri getir (Alt bayi seçimi için)
        $mainDealers = Dealer::where('dealer_type', 'Ana Bayi')->pluck('company_title', 'id');
        
        return view('dealers.create', compact('mainDealers'));
    }
    
    public function edit($id)
    {
        $dealer = Dealer::findOrFail($id);
        $mainDealers = Dealer::where('dealer_type', 'Ana Bayi')->pluck('company_title', 'id');
        
        return view('dealers.edit', compact('dealer', 'mainDealers'));
    }
    
    public function update(Request $request, $id)
    {
        $dealer = Dealer::findOrFail($id);
        
        $validated = $request->validate([
            'dealer_type' => 'required|in:Ana Bayi,Alt Bayi',
            'username' => 'required|unique:dealers,username,'.$id,
            'password' => 'nullable|min:6',
            'email' => 'required|email|unique:dealers,email,'.$id,
            'program_code' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'company_title' => 'required',
            'country' => 'required',
            'city' => 'required',
            'district' => 'required',
            'postal_code' => 'nullable',
            'address_title' => 'nullable',
            'address' => 'required',
            'address_description' => 'nullable',
            'phone' => 'required',
            'tax_office' => 'nullable',
            'tax_number' => 'nullable',
            'tax_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'signature_circular' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'trade_registry' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'findeks_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'balance' => 'nullable|numeric',
            'order_limit' => 'nullable|numeric',
            'yearly_target' => 'nullable|numeric',
            'representative' => 'nullable',
            'language' => 'required|in:Türkçe,English',
            'currency' => 'required|in:TRY,USD,EUR',
            'price_type' => 'required|in:perakende,toptan',
            'general_discount' => 'nullable|numeric|min:0|max:100',
            'additional_discount' => 'nullable|numeric|min:0|max:100',
            'extra_discount' => 'nullable|numeric|min:0|max:100',
            'discount_profile' => 'nullable',
            'main_dealer' => 'nullable|required_if:dealer_type,Alt Bayi',
        ]);
        
        try {
            $dealer->dealer_type = $validated['dealer_type'];
            $dealer->is_super_dealer = $request->has('is_super_dealer');
            $dealer->username = $validated['username'];
            if ($request->filled('password')) {
                $dealer->password = Hash::make($validated['password']);
            }
            $dealer->email = $validated['email'];
            $dealer->program_code = $validated['program_code'] ?? null;
            $dealer->is_active = $request->has('is_active');
            
            $dealer->first_name = $validated['first_name'];
            $dealer->last_name = $validated['last_name'];
            $dealer->company_title = $validated['company_title'];
            $dealer->country = $validated['country'];
            $dealer->city = $validated['city'];
            $dealer->district = $validated['district'];
            $dealer->postal_code = $validated['postal_code'] ?? null;
            $dealer->address_title = $validated['address_title'] ?? null;
            $dealer->address = $validated['address'];
            $dealer->address_description = $validated['address_description'] ?? null;
            $dealer->phone = $validated['phone'];
            $dealer->tax_office = $validated['tax_office'] ?? null;
            $dealer->tax_number = $validated['tax_number'] ?? null;
            
            // Boolean alanları
            $dealer->has_debt_order_block = $request->has('has_debt_order_block');
            $dealer->has_free_payment = $request->has('has_free_payment');
            $dealer->cash_only = $request->has('cash_only');
            $dealer->card_payment = $request->has('card_payment');
            $dealer->check_payment = $request->has('check_payment');
            $dealer->cash_payment = $request->has('cash_payment');
            $dealer->pay_at_door = $request->has('pay_at_door');
            $dealer->include_vat = $request->has('include_vat');
            $dealer->campaign_news = $request->has('campaign_news');
            $dealer->contract = $request->has('contract');
            $dealer->kvkk = $request->has('kvkk');
            $dealer->separate_warehouse = $request->has('separate_warehouse');
            $dealer->gift_passive = $request->has('gift_passive');
            
            // Zorunluluk kontrol alanları
            $dealer->tax_document_required = $request->has('tax_document_required');
            $dealer->signature_circular_required = $request->has('signature_circular_required');
            $dealer->trade_registry_required = $request->has('trade_registry_required');
            $dealer->findeks_report_required = $request->has('findeks_report_required');
            
            // Diğer alanlar
            $dealer->main_dealer = $validated['main_dealer'] ?? null;
            $dealer->balance = $validated['balance'] ?? 0;
            $dealer->order_limit = $validated['order_limit'] ?? 0;
            $dealer->yearly_target = $validated['yearly_target'] ?? 0;
            $dealer->representative = $validated['representative'] ?? null;
            $dealer->language = $validated['language'];
            $dealer->currency = $validated['currency'];
            $dealer->price_type = $validated['price_type'];
            $dealer->general_discount = $validated['general_discount'] ?? 0;
            $dealer->additional_discount = $validated['additional_discount'] ?? 0;
            $dealer->extra_discount = $validated['extra_discount'] ?? 0;
            $dealer->discount_profile = $validated['discount_profile'] ?? null;

            // Dosya yüklemeleri
            if ($request->hasFile('tax_document')) {
                if ($dealer->tax_document) {
                    Storage::disk('public')->delete($dealer->tax_document);
                }
                $dealer->tax_document = $request->file('tax_document')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('signature_circular')) {
                if ($dealer->signature_circular) {
                    Storage::disk('public')->delete($dealer->signature_circular);
                }
                $dealer->signature_circular = $request->file('signature_circular')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('trade_registry')) {
                if ($dealer->trade_registry) {
                    Storage::disk('public')->delete($dealer->trade_registry);
                }
                $dealer->trade_registry = $request->file('trade_registry')->store('dealer_documents', 'public');
            }
            
            if ($request->hasFile('findeks_report')) {
                if ($dealer->findeks_report) {
                    Storage::disk('public')->delete($dealer->findeks_report);
                }
                $dealer->findeks_report = $request->file('findeks_report')->store('dealer_documents', 'public');
            }

            $dealer->save();

            return redirect()->route('dealers.index')
                ->with('success', 'Bayi başarıyla güncellendi.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Bayi güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $dealer = Dealer::findOrFail($id);
            $dealer->delete();
            
            return response()->json(['success' => true, 'message' => 'Bayi başarıyla silindi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Bayi silinirken bir hata oluştu: ' . $e->getMessage()]);
        }
    }
    
    // Super Dealer ile ilgili işlemler
    public function createSuperDealer()
    {
        return view('dealers.create_super_dealer');
    }
    
    public function makeSuperDealer($id)
    {
        try {
            $dealer = Dealer::findOrFail($id);
            $dealer->is_super_dealer = true;
            $dealer->save();
            
            return redirect()->route('dealers.index')
                ->with('success', 'Bayi başarıyla Super Dealer yapıldı.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
    
    public function removeSuperDealer($id)
    {
        try {
            $dealer = Dealer::findOrFail($id);
            $dealer->is_super_dealer = false;
            $dealer->save();
            
            return redirect()->route('dealers.index')
                ->with('success', 'Bayi başarıyla Super Dealer statüsünden çıkarıldı.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
    
    public function superDealers()
    {
        $dealers = Dealer::where('is_super_dealer', true)->paginate(10);
        
        return view('dealers.super_dealers', compact('dealers'));
    }
} 