<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Durum filtreleri
        if ($request->has('filter')) {
            $filter = $request->filter;
            switch ($filter) {
                case 'kampanyali':
                    $query->where('is_campaign', true);
                    break;
                case 'hediyeli':
                    $query->where('has_gift', true);
                    break;
                case 'vitrin':
                    $query->where('is_showcase', true);
                    break;
                case 'cok-satan':
                    $query->where('is_bestseller', true);
                    break;
                case 'yeni':
                    $query->where('is_new', true);
                    break;
                case 'sayac':
                    $query->where('has_counter', true);
                    break;
                case 'indirim':
                    $query->where('has_discount_stock', true);
                    break;
                case 'pasif':
                    $query->where('is_passive', true);
                    break;
                case 'kapali':
                    $query->where('is_closed', true);
                    break;
            }
        }

        // Sayfalama
        $products = $query->paginate(10);

        // İstatistikler
        $stats = [
            'campaign' => Product::where('is_campaign', true)->count(),
            'gift' => Product::where('has_gift', true)->count(),
            'showcase' => Product::where('is_showcase', true)->count(),
            'bestseller' => Product::where('is_bestseller', true)->count(),
            'new' => Product::where('is_new', true)->count(),
            'counter' => Product::where('has_counter', true)->count(),
            'discount' => Product::where('has_discount_stock', true)->count(),
            'passive' => Product::where('is_passive', true)->count(),
            'closed' => Product::where('is_closed', true)->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'stats' => $stats
            ]);
        }

        return view('products', compact('products', 'stats'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'category' => 'required',
            'product_code' => 'nullable|unique:products,product_code',
            'name' => 'required',
            'name_en' => 'nullable',
            'unit' => 'nullable',
            'vat_rate' => 'nullable',
            'box_content' => 'nullable',
            'order' => 'nullable|numeric',
            'desi' => 'nullable|numeric',
            'points' => 'nullable|numeric',
            'barcode' => 'nullable',
            'price1' => 'nullable|numeric',
            'price2' => 'nullable|numeric',
            'price3' => 'nullable|numeric',
            'price4' => 'nullable|numeric',
            'price5' => 'nullable|numeric',
            'discounted_price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'discount_rate' => 'nullable|numeric',
            'additional_discount' => 'nullable|numeric',
            'discount_group_code' => 'nullable',
            'min_order' => 'nullable|numeric',
            'increment' => 'nullable|numeric',
            'max_order' => 'nullable|numeric',
            'warehouse1_stock' => 'nullable|numeric',
            'warehouse2_stock' => 'nullable|numeric',
            'warehouse3_stock' => 'nullable|numeric',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable',
            'description_en' => 'nullable',
            'search_tags' => 'nullable',
            'counter_date' => 'nullable|date',
            'discount_stock_date' => 'nullable|date',
        ]);

        $product = new Product();
        $product->fill($request->except('photo'));

        // Boolean alanları
        $product->is_passive = $request->has('is_passive');
        $product->is_closed = $request->has('is_closed');
        $product->is_out_of_stock = $request->has('is_out_of_stock');
        $product->is_showcase = $request->has('is_showcase');
        $product->is_bestseller = $request->has('is_bestseller');
        $product->is_campaign = $request->has('is_campaign');
        $product->has_gift = $request->has('has_gift');
        $product->is_new = $request->has('is_new');
        $product->has_counter = $request->has('has_counter');
        $product->has_discount_stock = $request->has('has_discount_stock');

        // Fotoğraf yükleme
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products', 'public');
            $product->photo = $path;
        }

        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Ürün başarıyla eklendi.');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
