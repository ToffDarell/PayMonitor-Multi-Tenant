<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $sales = Sale::with('customer')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create(): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;
        $customers = Customer::where('tenant_id', $tenantId)->get();
        $products = Product::where('tenant_id', $tenantId)->where('is_active', true)->get();
        $branches = Branch::where('tenant_id', $tenantId)->get();

        return view('sales.create', compact('customers', 'products', 'branches'));
    }

    public function store(SaleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $tenantId = auth()->user()->tenant_id;

        DB::transaction(function () use ($request, $tenantId) {
            $sale = Sale::create([
                'tenant_id'      => $tenantId,
                'branch_id'      => $request->branch_id,
                'customer_id'    => $request->customer_id,
                'user_id'        => auth()->id(),
                'reference'      => 'SALE-' . strtoupper(Str::random(8)),
                'subtotal'       => $request->subtotal,
                'discount'       => $request->discount ?? 0,
                'total'          => $request->total,
                'payment_method' => $request->payment_method,
                'status'         => $request->status ?? 'completed',
            ]);

            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total'      => $item['quantity'] * $item['unit_price'],
                ]);

                // Deduct stock
                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale): \Illuminate\View\View
    {
        abort_if($sale->tenant_id !== auth()->user()->tenant_id, 403);
        $sale->load('customer', 'items.product', 'user');

        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale): \Illuminate\Http\RedirectResponse
    {
        abort_if($sale->tenant_id !== auth()->user()->tenant_id, 403);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted.');
    }
}