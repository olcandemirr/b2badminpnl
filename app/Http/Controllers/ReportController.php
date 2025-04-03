<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function summary()
    {
        // Örnek veri - Gerçek uygulamada veritabanından gelecek
        $summaryData = [
            'siparis' => [
                'baslik' => 'Sipariş Raporlar',
                'items' => [
                    ['name' => 'Başlantıç Sayısı', 'value' => '0.00 TL'],
                    ['name' => '+ Hatalı Sayısı', 'value' => '0.00 TL'],
                    ['name' => 'Son 1 Ay Başlantıç', 'value' => '11.458.55 TL'],
                    ['name' => 'Son 1 Ay Hatalı', 'value' => '0.00 TL'],
                ]
            ],
            'bayi' => [
                'baslik' => 'Bayi Raporlar',
                'items' => [
                    ['name' => 'Son 1 Ay Bayi', 'value' => '2 kişi'],
                    ['name' => 'Toplam Bayi', 'value' => '0 kişi'],
                ]
            ],
            'urun' => [
                'baslik' => 'Ürün Raporlar',
                'items' => [
                    ['name' => 'Son 1 Ay Ürün', 'value' => '0 adet'],
                    ['name' => 'Toplam Ürün', 'value' => '0 adet'],
                ]
            ]
        ];

        return view('reports.summary', compact('summaryData'));
    }

    public function logs(Request $request)
    {
        // Örnek veri - Gerçek uygulamada veritabanından gelecek
        $logs = [
            [
                'id' => 1,
                'tarih' => '2025-04-03 16:16:44',
                'kulNo' => 13,
                'kulAdi' => 'b2badmin',
                'ip' => '85.104.192.212',
                'adSoyad' => 'Murat YEŞİLYURT',
                'unvan' => '',
                'islem' => 'AdminLogin',
                'kelime' => ''
            ],
            [
                'id' => 2,
                'tarih' => '2025-04-03 14:33:20',
                'kulNo' => 13,
                'kulAdi' => 'b2badmin',
                'ip' => '85.105.172.99',
                'adSoyad' => 'Murat YEŞİLYURT',
                'unvan' => '',
                'islem' => 'AdminLogin',
                'kelime' => ''
            ],
            [
                'id' => 3,
                'tarih' => '2025-04-03 03:22:52',
                'kulNo' => 9,
                'kulAdi' => 'b2bdemo',
                'ip' => '85.104.192.212',
                'adSoyad' => 'Murat YEŞİLYURT',
                'unvan' => 'xdizayn web tasarım',
                'islem' => 'Login',
                'kelime' => ''
            ]
        ];

        // Arama filtresi
        if ($request->has('search')) {
            $search = $request->search;
            $logs = array_filter($logs, function($log) use ($search) {
                return str_contains(strtolower(implode(' ', $log)), strtolower($search));
            });
        }

        // Tarih filtresi
        if ($request->has('start_date') && $request->has('end_date')) {
            $start = $request->start_date;
            $end = $request->end_date;
            $logs = array_filter($logs, function($log) use ($start, $end) {
                $date = date('Y-m-d', strtotime($log['tarih']));
                return $date >= $start && $date <= $end;
            });
        }

        return view('reports.logs', compact('logs'));
    }

    public function dealers(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $dealers = collect([]);

        return view('reports.dealers', compact('dealers'));
    }

    public function dailyDealerSales(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $sales = collect([]);

        return view('reports.daily-dealer-sales', compact('sales'));
    }

    public function yearlyDealerSales(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $sales = collect([]);

        return view('reports.yearly-dealer-sales', compact('sales'));
    }

    public function yearlySales(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $sales = collect([]);

        return view('reports.yearly-sales', compact('sales'));
    }

    public function representativeEarnings(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $earnings = collect([]);

        return view('reports.representative-earnings', compact('earnings'));
    }

    public function stockDetailReport(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $stocks = collect([]);

        return view('reports.stock-detail', compact('stocks'));
    }

    public function stockSummaryReport(Request $request)
    {
        // Boş koleksiyon oluştur - veriler veritabanından gelecek
        $stocks = collect([]);

        return view('reports.stock-summary', compact('stocks'));
    }
} 