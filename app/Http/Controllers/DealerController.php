<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $dealers = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'dealers' => $dealers
            ]);
        }

        return view('dealers.index', compact('dealers'));
    }

    public function exportExcel(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
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
            'tax_document' => 'nullable|file|mimes:pdf,jpg,jpeg',
            'signature_circular' => 'nullable|file|mimes:pdf,jpg,jpeg',
            'trade_registry' => 'nullable|file|mimes:pdf,jpg,jpeg',
            'findeks_report' => 'nullable|file|mimes:pdf,jpg,jpeg',
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
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['has_debt_order_block'] = $request->has('has_debt_order_block');
        $validated['has_free_payment'] = $request->has('has_free_payment');
        $validated['cash_only'] = $request->has('cash_only');
        $validated['card_payment'] = $request->has('card_payment');
        $validated['check_payment'] = $request->has('check_payment');
        $validated['cash_payment'] = $request->has('cash_payment');
        $validated['pay_at_door'] = $request->has('pay_at_door');
        $validated['include_vat'] = $request->has('include_vat');
        $validated['campaign_news'] = $request->has('campaign_news');
        $validated['contract'] = $request->has('contract');
        $validated['kvkk'] = $request->has('kvkk');
        $validated['separate_warehouse'] = $request->has('separate_warehouse');
        $validated['gift_passive'] = $request->has('gift_passive');
        $validated['tax_document_required'] = $request->has('tax_document_required');
        $validated['signature_circular_required'] = $request->has('signature_circular_required');
        $validated['trade_registry_required'] = $request->has('trade_registry_required');
        $validated['findeks_report_required'] = $request->has('findeks_report_required');

        // Handle file uploads
        $files = ['tax_document', 'signature_circular', 'trade_registry', 'findeks_report'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $path = $request->file($file)->store('dealer_documents', 'public');
                $validated[$file] = $path;
            }
        }

        // Create dealer
        $dealer = Dealer::create($validated);

        return redirect()->route('dealers.index')
            ->with('success', 'Bayi başarıyla oluşturuldu.');
    }

    public function create()
    {
        return view('dealers.create');
    }
} 