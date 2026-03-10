<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Tenant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;
        $branchId = auth()->user()->branch_id;

        $totalSales = Sale::where('tenant_id', $tenantId)->sum('total');
        $totalCredits = Credit::where('tenant_id', $tenantId)->where('status', '!=', 'paid')->sum('balance');
        $totalCustomers = Customer::where('tenant_id', $tenantId)->count();
        $totalProducts = Product::where('tenant_id', $tenantId)->count();

        $recentSales = Sale::with('customer')
            ->where('tenant_id', $tenantId)
            ->latest()
            ->limit(5)
            ->get();

        $overdueCredits = Credit::with('customer')
            ->where('tenant_id', $tenantId)
            ->where('status', 'overdue')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalSales', 'totalCredits', 'totalCustomers',
            'totalProducts', 'recentSales', 'overdueCredits'
        ));
    }

    public function superAdmin(): \Illuminate\View\View
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();
        $tenants = Tenant::with('plan')->latest()->limit(10)->get();

        return view('superadmin.dashboard', compact('totalTenants', 'activeTenants', 'tenants'));
    }
}