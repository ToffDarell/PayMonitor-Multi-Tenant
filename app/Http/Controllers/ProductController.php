<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Branch;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $products = Product::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create(): \Illuminate\View\View
    {
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('products.create', compact('branches'));
    }

    public function store(ProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        Product::create([
            ...$request->validated(),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product): \Illuminate\View\View
    {
        $this->authorizeTenant($product);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): \Illuminate\View\View
    {
        $this->authorizeTenant($product);
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('products.edit', compact('product', 'branches'));
    }

    public function update(ProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeTenant($product);
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeTenant($product);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    private function authorizeTenant(Product $product): void
    {
        abort_if($product->tenant_id !== auth()->user()->tenant_id, 403);
    }
}