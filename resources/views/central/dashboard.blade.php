@extends('layouts.central')

@section('title', 'Central Dashboard')

@section('content')
@php
    $statusBadge = static function (string $status): string {
        return match ($status) {
            'active' => 'success',
            'overdue' => 'danger',
            'suspended' => 'warning text-dark',
            'inactive' => 'secondary',
            default => 'light text-dark',
        };
    };

    $planBadge = static function (?string $planName): string {
        return match (strtolower($planName ?? '')) {
            'basic' => 'primary',
            'standard' => 'warning text-dark',
            'premium' => 'success',
            default => 'secondary',
        };
    };
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Central Dashboard</h1>
        <p class="text-muted mb-0">Overview of tenant health, billing, and recent onboardings.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-primary">Total</span>
                    <i class="bi bi-buildings text-primary fs-4"></i>
                </div>
                <h2 class="h4 mb-1">{{ number_format($totalTenants) }}</h2>
                <p class="text-muted mb-0">Total Tenants</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-success">Live</span>
                    <i class="bi bi-check-circle text-success fs-4"></i>
                </div>
                <h2 class="h4 mb-1">{{ number_format($activeTenants) }}</h2>
                <p class="text-muted mb-0">Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-danger">Alert</span>
                    <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                </div>
                <h2 class="h4 mb-1">{{ number_format($overdueTenants) }}</h2>
                <p class="text-muted mb-0">Overdue</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-warning text-dark">Paused</span>
                    <i class="bi bi-pause-circle text-warning fs-4"></i>
                </div>
                <h2 class="h4 mb-1">{{ number_format($suspendedTenants) }}</h2>
                <p class="text-muted mb-0">Suspended</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-secondary">Idle</span>
                    <i class="bi bi-slash-circle text-secondary fs-4"></i>
                </div>
                <h2 class="h4 mb-1">{{ number_format($inactiveTenants) }}</h2>
                <p class="text-muted mb-0">Inactive</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 col-xxl-2">
        <div class="card shadow-sm border-0 h-100 bg-info bg-opacity-10 border border-info border-opacity-25">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge text-bg-info">Revenue</span>
                    <i class="bi bi-currency-exchange text-info fs-4"></i>
                </div>
                <h2 class="h4 mb-1">&#8369;{{ number_format($monthlyRevenue, 2) }}</h2>
                <p class="text-muted mb-0">Monthly Revenue</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            <h2 class="h5 mb-0">Recent Tenants</h2>
        </div>
        <a href="{{ route('central.tenants.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-right-circle me-1"></i>Manage Tenants
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Cooperative Name</th>
                    <th>Plan</th>
                    <th>Domain</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTenants as $index => $tenant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $tenant->name }}</td>
                        <td>
                            <span class="badge bg-{{ $planBadge($tenant->plan?->name) }}">{{ $tenant->plan?->name ?? 'No Plan' }}</span>
                        </td>
                        <td>
                            <a href="{{ $tenant->getFullDomain() }}" target="_blank" class="text-decoration-none">
                                {{ parse_url($tenant->getFullDomain(), PHP_URL_HOST) }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusBadge($tenant->status) }}">{{ ucfirst($tenant->status) }}</span>
                        </td>
                        <td>{{ $tenant->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No tenants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
