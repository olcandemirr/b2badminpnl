<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
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

    public function pendingDetails(Request $request)
    {
        $query = OrderDetail::query()
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'pending')
            ->select('order_details.*', 'orders.order_number', 'orders.company_title', 'orders.customer_name');

        // Tarih filtresi
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('orders.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('orders.order_number', 'like', "%{$search}%")
                  ->orWhere('orders.company_title', 'like', "%{$search}%")
                  ->orWhere('orders.customer_name', 'like', "%{$search}%")
                  ->orWhere('order_details.product_code', 'like', "%{$search}%")
                  ->orWhere('order_details.product_name', 'like', "%{$search}%");
            });
        }

        $orderDetails = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'orderDetails' => $orderDetails
            ]);
        }

        return view('orders.pending-details', compact('orderDetails'));
    }

    public function exportPending(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }

    public function exportPendingDetails(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }

    public function approved(Request $request)
    {
        $query = Order::query()->where('status', 'approved');

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

        return view('orders.approved', compact('orders'));
    }

    public function approvedDetails(Request $request)
    {
        $query = OrderDetail::query()
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'approved')
            ->select('order_details.*', 'orders.order_number', 'orders.company_title', 'orders.customer_name');

        // Tarih filtresi
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('orders.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('orders.order_number', 'like', "%{$search}%")
                  ->orWhere('orders.company_title', 'like', "%{$search}%")
                  ->orWhere('orders.customer_name', 'like', "%{$search}%")
                  ->orWhere('order_details.product_code', 'like', "%{$search}%")
                  ->orWhere('order_details.product_name', 'like', "%{$search}%");
            });
        }

        $orderDetails = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'orderDetails' => $orderDetails
            ]);
        }

        return view('orders.approved-details', compact('orderDetails'));
    }

    public function exportApproved(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }

    public function exportApprovedDetails(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }

    public function cancelled(Request $request)
    {
        $query = Order::query()->where('status', 'cancelled');

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

        return view('orders.cancelled', compact('orders'));
    }

    public function cancelledDetails(Request $request)
    {
        $query = OrderDetail::query()
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'cancelled')
            ->select('order_details.*', 'orders.order_number', 'orders.company_title', 'orders.customer_name');

        // Tarih filtresi
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('orders.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('orders.order_number', 'like', "%{$search}%")
                  ->orWhere('orders.company_title', 'like', "%{$search}%")
                  ->orWhere('orders.customer_name', 'like', "%{$search}%")
                  ->orWhere('order_details.product_code', 'like', "%{$search}%")
                  ->orWhere('order_details.product_name', 'like', "%{$search}%");
            });
        }

        $orderDetails = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'orderDetails' => $orderDetails
            ]);
        }

        return view('orders.cancelled-details', compact('orderDetails'));
    }

    public function exportCancelled(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }

    public function exportCancelledDetails(Request $request)
    {
        // Excel export işlemi burada yapılacak
        return response()->download('path/to/excel/file.xlsx');
    }
}
