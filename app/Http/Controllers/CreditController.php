<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditRequest;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Sale;

class CreditController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $credits = Credit::with('customer')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('credits.index', compact('credits'));
    }

    public function create(): \Illuminate\View\View
    {
        $tenantId = auth()->user()->tenant_id;
        $customers = Customer::where('tenant_id', $tenantId)->get();
        $sales = Sale::where('tenant_id', $tenantId)->whereNull('credit_id')->get();

        return view('credits.create', compact('customers', 'sales'));
    }

    public function store(CreditRequest $request): \Illuminate\Http\RedirectResponse
    {
        $tenantId = auth()->user()->tenant_id;

        Credit::create([
            ...$request->validated(),
            'tenant_id'    => $tenantId,
            'branch_id'    => auth()->user()->branch_id,
            'amount_paid'  => 0,
            'balance'      => $request->amount,
            'status'       => 'unpaid',
        ]);

        return redirect()->route('credits.index')->with('success', 'Credit created successfully.');
    }

    public function show(Credit $credit): \Illuminate\View\View
    {
        abort_if($credit->tenant_id !== auth()->user()->tenant_id, 403);
        $credit->load('customer', 'payments', 'sale');

        return view('credits.show', compact('credit'));
    }
}