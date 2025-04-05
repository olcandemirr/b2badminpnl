<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function summary()
    {
        // Sipariş raporları
        $totalOrders = Order::count();
        $totalFailed = Order::where('status', 'cancelled')->count();
        $lastMonthOrders = Order::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $lastMonthFailed = Order::where('status', 'cancelled')->where('created_at', '>=', Carbon::now()->subMonth())->count();
        $totalOrderAmount = Order::where('status', 'approved')->sum('total');
        $lastMonthOrderAmount = Order::where('status', 'approved')->where('created_at', '>=', Carbon::now()->subMonth())->sum('total');

        // Bayi raporları
        $totalDealers = Dealer::count();
        $activeDealers = Dealer::where('is_active', true)->count();
        $lastMonthDealers = Dealer::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $superDealers = Dealer::where('is_super_dealer', true)->count();

        // Ürün raporları
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_passive', false)->count();
        $lastMonthProducts = Product::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $featuredProducts = Product::where('is_showcase', true)->count();

        $summaryData = [
            'siparis' => [
                'baslik' => 'Sipariş Raporları',
                'items' => [
                    ['name' => 'Toplam Sipariş Sayısı', 'value' => $totalOrders],
                    ['name' => 'Toplam Sipariş Tutarı', 'value' => number_format($totalOrderAmount, 2) . ' TL'],
                    ['name' => 'İptal Edilen Siparişler', 'value' => $totalFailed],
                    ['name' => 'Son 1 Ay Sipariş', 'value' => $lastMonthOrders],
                    ['name' => 'Son 1 Ay Sipariş Tutarı', 'value' => number_format($lastMonthOrderAmount, 2) . ' TL'],
                    ['name' => 'Son 1 Ay İptal', 'value' => $lastMonthFailed],
                ]
            ],
            'bayi' => [
                'baslik' => 'Bayi Raporları',
                'items' => [
                    ['name' => 'Toplam Bayi', 'value' => $totalDealers . ' bayi'],
                    ['name' => 'Aktif Bayi', 'value' => $activeDealers . ' bayi'],
                    ['name' => 'Super Dealer', 'value' => $superDealers . ' bayi'],
                    ['name' => 'Son 1 Ay Eklenen', 'value' => $lastMonthDealers . ' bayi'],
                ]
            ],
            'urun' => [
                'baslik' => 'Ürün Raporları',
                'items' => [
                    ['name' => 'Toplam Ürün', 'value' => $totalProducts . ' adet'],
                    ['name' => 'Aktif Ürün', 'value' => $activeProducts . ' adet'],
                    ['name' => 'Öne Çıkan Ürün', 'value' => $featuredProducts . ' adet'],
                    ['name' => 'Son 1 Ay Eklenen', 'value' => $lastMonthProducts . ' adet'],
                ]
            ]
        ];

        return view('reports.summary', compact('summaryData'));
    }

    public function logs(Request $request)
    {
        $query = Log::query()->with('user');
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('search')) {
            $query->where('details', 'like', '%' . $request->search . '%')
                ->orWhere('action', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        $users = User::orderBy('name')->get(['id', 'name']);
        
        return view('reports.logs', compact('logs', 'users'));
    }

    public function dealers(Request $request)
    {
        $query = Dealer::query();
        
        if ($request->filled('dealer_type')) {
            $query->where('dealer_type', $request->dealer_type);
        }
        
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        if ($request->has('is_super_dealer')) {
            $query->where('is_super_dealer', true);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('company_title', 'like', '%' . $request->search . '%')
                  ->orWhere('dealer_no', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('district', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sipariş toplamlarını hesapla (orders tablosu varsa)
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'dealer_id')) {
            $query->leftJoin('orders', 'dealers.id', '=', 'orders.dealer_id')
                  ->select('dealers.*', 
                      DB::raw('COUNT(orders.id) as total_orders'),
                      DB::raw('SUM(orders.total) as total_amount'))
                  ->groupBy('dealers.id');
        } else {
            // Orders tablosu yoksa sadece bayi bilgilerini getir
            $query->select('dealers.*')
                  ->selectRaw('0 as total_orders, 0 as total_amount');
        }
        
        $dealers = $query->orderBy('dealers.created_at', 'desc')->paginate(20);

        return view('reports.dealers', compact('dealers'));
    }

    public function dailyDealerSales(Request $request)
    {
        // Önce orders ve dealers tablolarının mevcut olup olmadığını kontrol edelim
        if (!Schema::hasTable('orders') || !Schema::hasTable('dealers') || 
            !Schema::hasColumn('orders', 'dealer_id')) {
            return view('reports.daily-dealer-sales', [
                'sales' => collect([]), 
                'dealers' => collect([])
            ])->with('error', 'Sipariş veya bayi verileri henüz oluşturulmamış.');
        }
        
        $query = DB::table('orders')
            ->join('dealers', 'orders.dealer_id', '=', 'dealers.id')
            ->select(
                'dealers.id as dealer_id',
                'dealers.dealer_no',
                'dealers.company_title',
                'dealers.dealer_type',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total) as total_amount'),
                DB::raw('DATE(orders.created_at) as order_date')
            )
            ->whereNotNull('orders.dealer_id')
            ->where('orders.status', 'approved')
            ->groupBy('dealers.id', 'dealers.dealer_no', 'dealers.company_title', 'dealers.dealer_type', 'order_date');

        // Tarih filtresi
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $query->where(DB::raw('DATE(orders.created_at)'), $date);
        } else {
            // Varsayılan olarak bugün
            $query->where(DB::raw('DATE(orders.created_at)'), Carbon::today()->format('Y-m-d'));
        }

        // Bayi filtresi
        if ($request->filled('dealer_id')) {
            $query->where('dealers.id', $request->dealer_id);
        }

        $sales = $query->orderBy('total_amount', 'desc')->paginate(15);
        
        // Bayi seçenekleri
        $dealers = Dealer::orderBy('company_title')->pluck('company_title', 'id');

        return view('reports.daily-dealer-sales', compact('sales', 'dealers'));
    }

    public function yearlyDealerSales(Request $request)
    {
        // Önce orders ve dealers tablolarının mevcut olup olmadığını kontrol edelim
        if (!Schema::hasTable('orders') || !Schema::hasTable('dealers') || 
            !Schema::hasColumn('orders', 'dealer_id')) {
            return view('reports.yearly-dealer-sales', [
                'sales' => collect([]), 
                'dealers' => collect([]),
                'years' => collect([])
            ])->with('error', 'Sipariş veya bayi verileri henüz oluşturulmamış.');
        }
        
        $query = DB::table('orders')
            ->join('dealers', 'orders.dealer_id', '=', 'dealers.id')
            ->select(
                'dealers.id as dealer_id',
                'dealers.dealer_no',
                'dealers.company_title',
                'dealers.dealer_type',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total) as total_amount'),
                DB::raw('YEAR(orders.created_at) as order_year')
            )
            ->whereNotNull('orders.dealer_id')
            ->where('orders.status', 'approved')
            ->groupBy('dealers.id', 'dealers.dealer_no', 'dealers.company_title', 'dealers.dealer_type', 'order_year');

        // Yıl filtresi
        if ($request->filled('year')) {
            $query->where(DB::raw('YEAR(orders.created_at)'), $request->year);
        } else {
            // Varsayılan olarak bu yıl
            $query->where(DB::raw('YEAR(orders.created_at)'), Carbon::now()->year);
        }

        // Bayi filtresi
        if ($request->filled('dealer_id')) {
            $query->where('dealers.id', $request->dealer_id);
        }

        $sales = $query->orderBy('total_amount', 'desc')->paginate(15);
        
        // Bayi seçenekleri
        $dealers = Dealer::orderBy('company_title')->pluck('company_title', 'id');
        
        // Yıl seçenekleri
        $years = DB::table('orders')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('reports.yearly-dealer-sales', compact('sales', 'dealers', 'years'));
    }

    public function yearlySales(Request $request)
    {
        $query = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(id) as order_count'),
                DB::raw('SUM(total) as total_amount'),
                DB::raw('AVG(total) as average_amount')
            )
            ->where('status', 'approved')
            ->groupBy('year', 'month');

        // Yıl filtresi
        if ($request->filled('year')) {
            $query->where(DB::raw('YEAR(created_at)'), $request->year);
        } else {
            // Varsayılan olarak bu yıl
            $query->where(DB::raw('YEAR(created_at)'), Carbon::now()->year);
        }

        $salesData = $query->orderBy('year')->orderBy('month')->get();
        
        // Ayları düzenlenmiş bir array haline getirelim
        $sales = [];
        foreach ($salesData as $data) {
            $monthName = Carbon::createFromDate(null, $data->month, 1)->format('F');
            $sales[] = [
                'year' => $data->year,
                'month' => $data->month,
                'month_name' => $monthName,
                'order_count' => $data->order_count,
                'total_amount' => $data->total_amount,
                'average_amount' => $data->average_amount,
            ];
        }
        
        // Yıl seçenekleri
        $years = DB::table('orders')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('reports.yearly-sales', compact('sales', 'years'));
    }

    public function representativeEarnings(Request $request)
    {
        // Önce orders ve dealers tablolarının mevcut olup olmadığını kontrol edelim
        if (!Schema::hasTable('orders') || !Schema::hasTable('dealers') || 
            !Schema::hasColumn('orders', 'dealer_id') || 
            !Schema::hasColumn('dealers', 'representative')) {
            return view('reports.representative-earnings', [
                'earnings' => collect([]), 
                'representatives' => collect([])
            ])->with('error', 'Sipariş veya bayi verileri henüz oluşturulmamış.');
        }
        
        $query = DB::table('orders')
            ->join('dealers', 'orders.dealer_id', '=', 'dealers.id')
            ->select(
                'dealers.representative',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total) as total_amount'),
                DB::raw('COUNT(DISTINCT dealers.id) as dealer_count')
            )
            ->whereNotNull('dealers.representative')
            ->where('orders.status', 'approved')
            ->groupBy('dealers.representative');

        // Tarih filtresi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('orders.created_at', [$startDate, $endDate]);
        }

        // Temsilci filtresi
        if ($request->filled('representative')) {
            $query->where('dealers.representative', $request->representative);
        }

        $earnings = $query->orderBy('total_amount', 'desc')->paginate(15);
        
        // Temsilci seçenekleri
        $representatives = Dealer::whereNotNull('representative')
            ->distinct()
            ->orderBy('representative')
            ->pluck('representative');

        return view('reports.representative-earnings', compact('earnings', 'representatives'));
    }

    public function stockDetailReport(Request $request)
    {
        $query = Product::query();

        // Ürün adı filtresi
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Kategori filtresi
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Stok durumu filtresi
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where(function($q) {
                    $q->where('warehouse1_stock', '>', 0)
                      ->orWhere('warehouse2_stock', '>', 0)
                      ->orWhere('warehouse3_stock', '>', 0);
                });
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where(function($q) {
                    $q->where('warehouse1_stock', '<=', 0)
                      ->where('warehouse2_stock', '<=', 0)
                      ->where('warehouse3_stock', '<=', 0);
                })->orWhereNull('warehouse1_stock')
                  ->orWhereNull('warehouse2_stock')
                  ->orWhereNull('warehouse3_stock');
            } elseif ($request->stock_status === 'low_stock') {
                $query->where(function($q) {
                    $q->where('warehouse1_stock', '>', 0)
                      ->where('warehouse1_stock', '<=', 10);
                })->orWhere(function($q) {
                    $q->where('warehouse2_stock', '>', 0)
                      ->where('warehouse2_stock', '<=', 10);
                })->orWhere(function($q) {
                    $q->where('warehouse3_stock', '>', 0)
                      ->where('warehouse3_stock', '<=', 10);
                });
            }
        }

        $stocks = $query->orderBy('name')->paginate(15);
        
        // Kategori seçenekleri - Ürün tablosundan benzersiz kategorileri çekelim
        $categories = DB::table('products')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category', 'category');

        return view('reports.stock-detail', compact('stocks', 'categories'));
    }

    public function stockSummaryReport(Request $request)
    {
        $query = DB::table('products');
            
        // Kategori bazlı gruplandırma
        $query->select(
            'category',
            DB::raw('COUNT(id) as product_count'),
            DB::raw('SUM(warehouse1_stock + warehouse2_stock + warehouse3_stock) as total_stock'),
            DB::raw('SUM(price1 * (warehouse1_stock + warehouse2_stock + warehouse3_stock)) as total_stock_value'),
            DB::raw('AVG(price1) as average_price'),
            DB::raw('MIN(price1) as min_price'),
            DB::raw('MAX(price1) as max_price')
        )
        ->groupBy('category');

        // Kategori filtresi
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $stocks = $query->orderBy('category')->paginate(15);
        
        // Kategori seçenekleri - Ürün tablosundan benzersiz kategorileri çekelim
        $categories = DB::table('products')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category', 'category');

        return view('reports.stock-summary', compact('stocks', 'categories'));
    }
    
    // CSV export metotları
    public function exportLogs(Request $request)
    {
        $query = Log::query()->with('user');
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('search')) {
            $query->where('details', 'like', '%' . $request->search . '%')
                ->orWhere('action', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }
        
        $logs = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'sistem_loglari_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            // BOM (Byte Order Mark) ekleyelim - UTF-8 için
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Başlıklar
            fputcsv($file, [
                'ID',
                'Tarih',
                'Kullanıcı',
                'IP Adresi',
                'İşlem',
                'Detay'
            ], ';');
            
            // Veriler
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->created_at->format('d.m.Y H:i:s'),
                    $log->user ? $log->user->name : 'Bilinmiyor',
                    $log->ip_address,
                    $log->action,
                    $log->details
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportDealers(Request $request)
    {
        $query = Dealer::query();
        
        if ($request->filled('dealer_type')) {
            $query->where('dealer_type', $request->dealer_type);
        }
        
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        if ($request->has('is_super_dealer')) {
            $query->where('is_super_dealer', true);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('company_title', 'like', '%' . $request->search . '%')
                  ->orWhere('dealer_no', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('district', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sipariş toplamlarını hesapla (orders tablosu varsa)
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'dealer_id')) {
            $query->leftJoin('orders', 'dealers.id', '=', 'orders.dealer_id')
                  ->select('dealers.*', 
                      DB::raw('COUNT(orders.id) as total_orders'),
                      DB::raw('SUM(orders.total) as total_amount'))
                  ->groupBy('dealers.id');
        } else {
            // Orders tablosu yoksa sadece bayi bilgilerini getir
            $query->select('dealers.*')
                  ->selectRaw('0 as total_orders, 0 as total_amount');
        }
              
        $dealers = $query->orderBy('dealers.created_at', 'desc')->get();
        
        $filename = 'bayiler_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
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
                'Bayi Tipi',
                'E-mail',
                'Telefon',
                'Şehir',
                'İlçe',
                'Toplam Sipariş',
                'Toplam Tutar (TL)',
                'Super Bayi',
                'Kayıt Tarihi',
                'Durum'
            ], ';');
            
            // Veriler
            foreach ($dealers as $dealer) {
                fputcsv($file, [
                    $dealer->id,
                    $dealer->dealer_no,
                    $dealer->company_title,
                    $dealer->dealer_type,
                    $dealer->email,
                    $dealer->phone,
                    $dealer->city,
                    $dealer->district,
                    $dealer->total_orders ?? 0,
                    number_format($dealer->total_amount ?? 0, 2),
                    $dealer->is_super_dealer ? 'Evet' : 'Hayır',
                    $dealer->created_at->format('d.m.Y'),
                    $dealer->is_active ? 'Aktif' : 'Pasif'
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportSales(Request $request)
    {
        // İleride gerçek export implemente edilecek
        return back()->with('error', 'Satış raporları dışa aktarımı henüz hazır değil.');
    }
    
    public function exportStocks(Request $request)
    {
        // İleride gerçek export implemente edilecek
        return back()->with('error', 'Stok raporları dışa aktarımı henüz hazır değil.');
    }
} 