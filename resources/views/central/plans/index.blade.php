@extends('layouts.central')

@section('title', 'Plans')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Plans</h1>
        <p class="text-muted mb-0">Manage subscription tiers for lending cooperative tenants.</p>
    </div>
    <a href="{{ route('central.plans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Add Plan
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Max Branches</th>
                    <th>Max Users</th>
                    <th>Tenants Count</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    @php($hasTenants = $plan->tenants_count > 0)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $plan->name }}</td>
                        <td>&#8369;{{ number_format((float) $plan->price, 2) }}</td>
                        <td>{{ (int) $plan->max_branches === 0 ? 'Unlimited' : number_format($plan->max_branches) }}</td>
                        <td>{{ (int) $plan->max_users === 0 ? 'Unlimited' : number_format($plan->max_users) }}</td>
                        <td>{{ number_format($plan->tenants_count) }}</td>
                        <td class="text-end">
                            <a href="{{ route('central.plans.edit', $plan) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            @if($hasTenants)
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Cannot delete plan with active tenants" disabled>
                                    <i class="bi bi-lock me-1"></i>Delete
                                </button>
                            @else
                                <form method="POST" action="{{ route('central.plans.destroy', $plan) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this plan?')">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No plans found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (element) {
            new bootstrap.Tooltip(element);
        });
    });
</script>
@endpush
