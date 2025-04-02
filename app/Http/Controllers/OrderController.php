<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function pending(Request $request)
    {
        $query = Order::query()->where('status', 'pending');

        // Tarih filtresi
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('company_title', 'like', "%{$search}%")
                  ->orWhere('dealer_type', 'like', "%{$search}%")
                  ->orWhere('main_dealer', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'orders' => $orders
            ]);
        }

        return view('orders.pending', compact('orders'));
    }

    public function exportPending(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }
}
