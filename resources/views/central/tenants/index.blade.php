@extends('layouts.central')

@section('title', 'Tenant Management')

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

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Tenant Management</h1>
        <p class="text-muted mb-0">Manage cooperative accounts, subscriptions, and provisioning actions.</p>
    </div>
    <a href="{{ route('central.tenants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Add Tenant
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-6 col-lg-4 ms-auto">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="search" id="tenantSearch" class="form-control" placeholder="Search tenant list...">
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0" id="tenantTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Cooperative Name</th>
                    <th>Address</th>
                    <th>Domain</th>
                    <th>Admin Name</th>
                    <th>Admin Email</th>
                    <th>Plan</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>DB Usage</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    @php
                        $domainUrl = $tenant->getFullDomain();
                        $dueDate = $tenant->subscription_due_at;
                        $deleteModalId = 'deleteTenantModal'.$loop->iteration;
                    @endphp
                    <tr>
                        <td>{{ $tenants->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $tenant->name }}</td>
                        <td>{{ $tenant->address ?: 'N/A' }}</td>
                        <td>
                            <a href="{{ $domainUrl }}" target="_blank" class="text-decoration-none">
                                {{ parse_url($domainUrl, PHP_URL_HOST) }}
                            </a>
                        </td>
                        <td>{{ $tenant->admin_name ?: 'N/A' }}</td>
                        <td>{{ $tenant->email }}</td>
                        <td><span class="badge bg-{{ $planBadge($tenant->plan?->name) }}">{{ $tenant->plan?->name ?? 'No Plan' }}</span></td>
                        <td class="{{ $dueDate && $dueDate->isPast() ? 'text-danger fw-semibold' : '' }}">
                            {{ $dueDate?->format('M d, Y') ?? 'N/A' }}
                        </td>
                        <td><span class="badge bg-{{ $statusBadge($tenant->status) }}">{{ ucfirst($tenant->status) }}</span></td>
                        <td>{{ number_format(data_get($tenant->usage, 'total', 0)) }} records</td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('central.tenants.show', $tenant) }}"><i class="bi bi-eye me-2"></i>View</a></li>
                                    <li><a class="dropdown-item" href="{{ route('central.tenants.edit', $tenant) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    @if($tenant->status === 'suspended')
                                        <li>
                                            <form method="POST" action="{{ route('central.tenants.activate', $tenant) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success"><i class="bi bi-play-circle me-2"></i>Activate</button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <form method="POST" action="{{ route('central.tenants.suspend', $tenant) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-warning"><i class="bi bi-pause-circle me-2"></i>Suspend</button>
                                            </form>
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('central.tenants.resend-credentials', $tenant) }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="bi bi-envelope-arrow-up me-2"></i>Resend Credentials</button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#{{ $deleteModalId }}">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="modal fade" id="{{ $deleteModalId }}" tabindex="-1" aria-hidden="true">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-5 text-muted">No tenants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tenants->hasPages())
        <div class="card-footer bg-white">
            {{ $tenants->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('tenantSearch');
        const tableRows = document.querySelectorAll('#tenantTable tbody tr');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const keyword = this.value.toLowerCase().trim();
                tableRows.forEach(function (row) {
                    row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
