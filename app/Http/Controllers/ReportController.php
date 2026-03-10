<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;

        $query = Sale::with('customer')
            ->where('tenant_id', $tenantId);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $sales = $query->latest()->paginate(20);
        $totalRevenue = $query->sum('total');

        return view('reports.sales', compact('sales', 'totalRevenue'));
    }

    public function credits(Request $request): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;

        $credits = Credit::with('customer')
            ->where('tenant_id', $tenantId)
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        $totalOutstanding = Credit::where('tenant_id', $tenantId)
            ->where('status', '!=', 'paid')
            ->sum('balance');

        return view('reports.credits', compact('credits', 'totalOutstanding'));
    }

    public function products(Request $request): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;

        $products = Product::where('tenant_id', $tenantId)
            ->when($request->low_stock, fn ($q) => $q->where('stock', '<=', 10))
            ->latest()
            ->paginate(20);

        return view('reports.products', compact('products'));
    }
}