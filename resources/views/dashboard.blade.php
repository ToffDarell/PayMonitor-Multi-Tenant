@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3 fs-4 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Sales</div>
                    <div class="fw-bold fs-5">₱{{ number_format($totalSales, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-danger bg-opacity-10 p-3 fs-4 text-danger">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div>
                    <div class="text-muted small">Outstanding Credits</div>
                    <div class="fw-bold fs-5">₱{{ number_format($totalCredits, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success bg-opacity-10 p-3 fs-4 text-success">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted small">Customers</div>
                    <div class="fw-bold fs-5">{{ number_format($totalCustomers) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3 fs-4 text-warning">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="text-muted small">Products</div>
                    <div class="fw-bold fs-5">{{ number_format($totalProducts) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold border-bottom">Recent Sales</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                            <tr>
                                <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->reference }}</a></td>
                                <td>{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                                <td>₱{{ number_format($sale->total, 2) }}</td>
                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No sales yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold border-bottom text-danger">Overdue Credits</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueCredits as $credit)
                            <tr>
                                <td><a href="{{ route('credits.show', $credit) }}">{{ $credit->customer?->name }}</a></td>
                                <td class="text-danger">₱{{ number_format($credit->balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted py-3">No overdue credits.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
