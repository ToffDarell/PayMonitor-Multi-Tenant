@extends('layouts.central')

@section('title', 'Add Plan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Add Plan</h1>
        <p class="text-muted mb-0">Create a new subscription tier for central tenant billing.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('central.plans.store') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Price (&#8369;)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="max_branches" class="form-label">Max Branches</label>
                    <input type="number" id="max_branches" name="max_branches" value="{{ old('max_branches', 0) }}" class="form-control @error('max_branches') is-invalid @enderror" required>
                    <div class="form-text">Enter 0 for unlimited.</div>
                    @error('max_branches')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="max_users" class="form-label">Max Users</label>
                    <input type="number" id="max_users" name="max_users" value="{{ old('max_users', 0) }}" class="form-control @error('max_users') is-invalid @enderror" required>
                    <div class="form-text">Enter 0 for unlimited.</div>
                    @error('max_users')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Plan</button>
                <a href="{{ route('central.plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
