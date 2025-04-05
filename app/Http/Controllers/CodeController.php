<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Category;
use App\Models\Product;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodeController extends Controller
{
    public function index(Request $request)
    {
        $query = Code::query();

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Kod türü filtresi
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $codes = $query->orderBy('id', 'desc')->paginate(10);

        return view('codes.index', compact('codes'));
    }

    public function create()
    {
        // Kategori, ürün ve bayi listelerini getir
        $categories = Category::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $dealers = Dealer::pluck('company_title', 'id');
        
        return view('codes.create', compact('categories', 'products', 'dealers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:codes',
            'type' => 'required|in:genel,ozel',
            'description' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'dealer_id' => 'nullable|exists:dealers,id',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
        ]);

        // is_active checkbox kontrolü
        $validated['is_active'] = $request->has('is_active');
        
        // Yeni kod oluştur
        try {
            DB::beginTransaction();
            
            $code = Code::create($validated);
            
            DB::commit();
            
            return redirect()->route('codes.index')
                ->with('success', 'Kod başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->withInput()
                ->with('error', 'Kod oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $code = Code::findOrFail($id);
        
        // Kategori, ürün ve bayi listelerini getir
        $categories = Category::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $dealers = Dealer::pluck('company_title', 'id');
        
        return view('codes.edit', compact('code', 'categories', 'products', 'dealers'));
    }

    public function update(Request $request, $id)
    {
        $code = Code::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:codes,code,' . $id,
            'type' => 'required|in:genel,ozel',
            'description' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'dealer_id' => 'nullable|exists:dealers,id',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
        ]);

        // is_active checkbox kontrolü
        $validated['is_active'] = $request->has('is_active');
        
        try {
            DB::beginTransaction();
            
            $code->update($validated);
            
            DB::commit();
            
            return redirect()->route('codes.index')
                ->with('success', 'Kod başarıyla güncellendi.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->withInput()
                ->with('error', 'Kod güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $code = Code::findOrFail($id);
            $code->delete();
            
            return response()->json(['success' => true, 'message' => 'Kod başarıyla silindi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Kod silinirken bir hata oluştu: ' . $e->getMessage()]);
        }
    }
} 