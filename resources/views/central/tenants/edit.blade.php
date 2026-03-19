@extends('layouts.central')

@section('title', 'Edit Tenant')

@section('content')
@php
    $domainRecord = $tenant->domains()->value('domain');
    $subdomain = $domainRecord ? explode('.', $domainRecord)[0] : $tenant->id;
    $tenantBaseDomain = config('tenancy.tenant_base_domain', 'localhost');
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Edit Tenant</h1>
        <p class="text-muted mb-0">Update the cooperative subscription and account details.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('central.tenants.update', $tenant) }}">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Business/Cooperative Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $tenant->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $tenant->address) }}" class="form-control @error('address') is-invalid @enderror" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subdomain</label>
                    <div class="form-control bg-light">{{ $subdomain }}.{{ $tenantBaseDomain }}</div>
                </div>
                <div class="col-md-6">
                    <label for="plan_id" class="form-label">Plan *</label>
                    <select id="plan_id" name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id', $tenant->plan_id) == $plan->id)>
                                {{ $plan->name }} - &#8369;{{ number_format((float) $plan->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Admin Name</label>
                    <div class="form-control bg-light">{{ $tenant->admin_name ?: 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Admin Email</label>
                    <div class="form-control bg-light">{{ $tenant->email }}</div>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        @foreach(['active', 'overdue', 'suspended', 'inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $tenant->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="subscription_due_at" class="form-label">Subscription Due Date</label>
                    <input type="date" id="subscription_due_at" name="subscription_due_at" value="{{ old('subscription_due_at', $tenant->subscription_due_at?->toDateString()) }}" class="form-control @error('subscription_due_at') is-invalid @enderror">
                    @error('subscription_due_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-1"></i>Update Tenant
                </button>
                <a href="{{ route('central.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
