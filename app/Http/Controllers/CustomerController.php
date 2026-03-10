<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Branch;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $customers = Customer::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create(): \Illuminate\View\View
    {
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('customers.create', compact('branches'));
    }

    public function store(CustomerRequest $request): \Illuminate\Http\RedirectResponse
    {
        Customer::create([
            ...$request->validated(),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer): \Illuminate\View\View
    {
        $this->authorizeTenant($customer);
        $customer->load(['sales', 'credits']);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): \Illuminate\View\View
    {
        $this->authorizeTenant($customer);
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('customers.edit', compact('customer', 'branches'));
    }

    public function update(CustomerRequest $request, Customer $customer): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeTenant($customer);
        $customer->update($request->validated());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeTenant($customer);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }

    private function authorizeTenant(Customer $customer): void
    {
        abort_if($customer->tenant_id !== auth()->user()->tenant_id, 403);
    }
}