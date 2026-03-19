@extends('layouts.central')

@section('title', 'Add New Tenant')

@section('content')
@php($tenantBaseDomain = config('tenancy.tenant_base_domain', 'localhost'))
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Add New Tenant</h1>
        <p class="text-muted mb-0">Create a new lending cooperative tenant and send its admin credentials.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('central.tenants.store') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Business/Cooperative Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="domain" class="form-label">Subdomain *</label>
                    <input type="text" id="domain" name="domain" value="{{ old('domain') }}" class="form-control @error('domain') is-invalid @enderror" required>
                    <div class="form-text">e.g. alpha -&gt; alpha.{{ $tenantBaseDomain }}</div>
                    @error('domain')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="plan_id" class="form-label">Plan *</label>
                    <select id="plan_id" name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                        <option value="">Select a plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                                {{ $plan->name }} - &#8369;{{ number_format((float) $plan->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="admin_name" class="form-label">Admin Name *</label>
                    <input type="text" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" class="form-control @error('admin_name') is-invalid @enderror" required>
                    @error('admin_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="admin_email" class="form-label">Admin Email *</label>
                    <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" class="form-control @error('admin_email') is-invalid @enderror" required>
                    @error('admin_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="subscription_due_at" class="form-label">Subscription Due Date *</label>
                    <input type="date" id="subscription_due_at" name="subscription_due_at" value="{{ old('subscription_due_at') }}" class="form-control @error('subscription_due_at') is-invalid @enderror" required>
                    @error('subscription_due_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-check me-1"></i>Create Tenant &amp; Send Credentials
                </button>
                <a href="{{ route('central.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
