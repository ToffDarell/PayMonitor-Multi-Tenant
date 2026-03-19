@extends('layouts.central')

@section('title', 'Tenant Profile')

@section('content')
@php
    $domainUrl = $primaryDomain?->domain ? ((str_starts_with($primaryDomain->domain, 'http://') || str_starts_with($primaryDomain->domain, 'https://')) ? $primaryDomain->domain : 'https://'.$primaryDomain->domain) : $tenant->getFullDomain();
    $statusBadge = match ($tenant->status) {
        'active' => 'success',
        'overdue' => 'danger',
        'suspended' => 'warning text-dark',
        'inactive' => 'secondary',
        default => 'light text-dark',
    };
    $planBadge = match (strtolower($tenant->plan?->name ?? '')) {
        'basic' => 'primary',
        'standard' => 'warning text-dark',
        'premium' => 'success',
        default => 'secondary',
    };
    $dueDate = $tenant->subscription_due_at;
    $daysDifference = $dueDate ? today()->diffInDays($dueDate, false) : null;
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $tenant->name }}</h1>
        <p class="text-muted mb-0">Tenant profile, subscription details, and database usage snapshot.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('central.tenants.edit', $tenant) }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i>Edit
        </a>
        @if($tenant->status === 'suspended')
            <form method="POST" action="{{ route('central.tenants.activate', $tenant) }}">
                @csrf
                <button type="submit" class="btn btn-success"><i class="bi bi-play-circle me-1"></i>Activate</button>
            </form>
        @else
            <form method="POST" action="{{ route('central.tenants.suspend', $tenant) }}">
                @csrf
                <button type="submit" class="btn btn-warning"><i class="bi bi-pause-circle me-1"></i>Suspend</button>
            </form>
        @endif
        <form method="POST" action="{{ route('central.tenants.resend-credentials', $tenant) }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-envelope-arrow-up me-1"></i>Resend Credentials</button>
        </form>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTenantModal">
            <i class="bi bi-trash me-1"></i>Delete
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h2 class="h5 mb-0">Tenant Profile</h2>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Cooperative</dt>
                    <dd class="col-sm-8">{{ $tenant->name }}</dd>
                    <dt class="col-sm-4">Address</dt>
                    <dd class="col-sm-8">{{ $tenant->address ?: 'N/A' }}</dd>
                    <dt class="col-sm-4">Domain</dt>
                    <dd class="col-sm-8"><a href="{{ $domainUrl }}" target="_blank">{{ parse_url($domainUrl, PHP_URL_HOST) }}</a></dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8"><span class="badge bg-{{ $statusBadge }}">{{ ucfirst($tenant->status) }}</span></dd>
                    <dt class="col-sm-4">Plan</dt>
                    <dd class="col-sm-8"><span class="badge bg-{{ $planBadge }}">{{ $tenant->plan?->name ?? 'No Plan' }}</span></dd>
                    <dt class="col-sm-4">Created At</dt>
                    <dd class="col-sm-8">{{ $tenant->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h2 class="h5 mb-0">Subscription</h2>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Plan Name</dt>
                    <dd class="col-sm-7">{{ $tenant->plan?->name ?? 'No Plan' }}</dd>
                    <dt class="col-sm-5">Price</dt>
                    <dd class="col-sm-7">&#8369;{{ number_format((float) ($tenant->plan?->price ?? 0), 2) }}</dd>
                    <dt class="col-sm-5">Due Date</dt>
                    <dd class="col-sm-7">{{ $dueDate?->format('M d, Y') ?? 'N/A' }}</dd>
                    <dt class="col-sm-5">Status Window</dt>
                    <dd class="col-sm-7">
                        @if($daysDifference === null)
                            <span class="text-muted">No due date set</span>
                        @elseif($daysDifference >= 0)
                            <span class="text-success fw-semibold">{{ $daysDifference }} day{{ $daysDifference === 1 ? '' : 's' }} remaining</span>
                        @else
                            <span class="text-danger fw-semibold">{{ abs($daysDifference) }} day{{ abs($daysDifference) === 1 ? '' : 's' }} overdue</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h2 class="h5 mb-0">Admin Info</h2>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <div class="text-muted small mb-1">Admin Name</div>
                    <div class="fw-semibold">{{ $tenant->admin_name ?: 'N/A' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <div class="text-muted small mb-1">Admin Email</div>
                    <div class="fw-semibold">{{ $tenant->email }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h2 class="h5 mb-0">Usage Stats</h2>
    </div>
    <div class="card-body">
        <div class="row g-3 text-center">
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Branches</div><div class="fs-4 fw-bold">{{ number_format($usage['branches']) }}</div></div></div>
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Users</div><div class="fs-4 fw-bold">{{ number_format($usage['users']) }}</div></div></div>
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Members</div><div class="fs-4 fw-bold">{{ number_format($usage['members']) }}</div></div></div>
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Loan Types</div><div class="fs-4 fw-bold">{{ number_format($usage['loan_types']) }}</div></div></div>
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Loans</div><div class="fs-4 fw-bold">{{ number_format($usage['loans']) }}</div></div></div>
            <div class="col-md-2"><div class="border rounded p-3"><div class="text-muted small">Total Records</div><div class="fs-4 fw-bold">{{ number_format($usage['total']) }}</div></div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteTenantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $tenant->name }}</strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('central.tenants.destroy', $tenant) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Tenant</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
