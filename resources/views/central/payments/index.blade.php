@extends('layouts.central')

@section('title', 'Payments')

@section('content')
@php
    $statusBadge = static function (string $status): string {
        return match ($status) {
            'current' => 'success',
            'due_soon' => 'warning text-dark',
            'overdue' => 'danger',
            default => 'secondary',
        };
    };
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Payments</h1>
        <p class="text-muted mb-0">Track current subscriptions, due accounts, and mark tenant payments.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-4 ms-auto">
                <label for="paymentStatusFilter" class="form-label mb-1">Filter by status</label>
                <select id="paymentStatusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="current">Current</option>
                    <option value="due_soon">Due Soon</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="paymentsTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Cooperative Name</th>
                    <th>Plan</th>
                    <th>Amount (&#8369;)</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Days Overdue</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    @php
                        $dueDate = $tenant->subscription_due_at;
                        $daysOverdue = $dueDate && $dueDate->isPast() ? $dueDate->diffInDays(today()) : 0;
                    @endphp
                    <tr data-status="{{ $tenant->payment_status }}">
                        <td>{{ $tenants->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $tenant->name }}</td>
                        <td>{{ $tenant->plan?->name ?? 'No Plan' }}</td>
                        <td>&#8369;{{ number_format((float) ($tenant->plan?->price ?? 0), 2) }}</td>
                        <td>{{ $dueDate?->format('M d, Y') ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $statusBadge($tenant->payment_status) }}">{{ ucfirst(str_replace('_', ' ', $tenant->payment_status)) }}</span></td>
                        <td>{{ $tenant->payment_status === 'overdue' ? number_format($daysOverdue) : '-' }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('central.payments.mark-paid', $tenant) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check2-circle me-1"></i>Mark as Paid
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No payment records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tenants->hasPages())
        <div class="card-footer bg-white">{{ $tenants->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('paymentStatusFilter');
        const rows = document.querySelectorAll('#paymentsTable tbody tr[data-status]');

        filter.addEventListener('change', function () {
            const selected = this.value;
            rows.forEach(function (row) {
                row.style.display = !selected || row.dataset.status === selected ? '' : 'none';
            });
        });
    });
</script>
@endpush
