@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Leave Management</h1>
    <a href="{{ route('leave-requests.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Request Leave
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Filter Leave Requests</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('leave-requests.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-select" id="employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" 
                                        {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="type" class="form-label">Leave Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">All Types</option>
                            <option value="annual" {{ request('type') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="sick" {{ request('type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="personal" {{ request('type') == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                            <option value="maternity" {{ request('type') == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                            <option value="paternity" {{ request('type') == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                            <option value="unpaid" {{ request('type') == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" title="Apply Filter">
                                <i class="fas fa-filter me-1"></i>
                            </button>
                            <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary" title="Reset Filter">
                                <i class="fas fa-undo me-1"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Leave Requests</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Date Range</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveRequests as $leave)
                                <tr>
                                    <td>{{ $leave->employee->full_name }}</td>
                                    <td>{{ ucfirst($leave->type) }} Leave</td>
                                    <td>{{ $leave->formatted_date_range }}</td>
                                    <td>{{ $leave->total_days }} day(s)</td>
                                    <td>
                                        <span class="badge bg-{{ $leave->status_badge }}">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('leave-requests.show', $leave) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($leave->isPending())
                                                <a href="{{ route('leave-requests.edit', $leave) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Request">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Approve Request"
                                                        onclick="approveLeave({{ $leave->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Reject Request"
                                                        onclick="rejectLeave({{ $leave->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <form id="approve-form-{{ $leave->id }}" 
                                                      action="{{ route('leave-requests.approve', $leave) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <form id="reject-form-{{ $leave->id }}" 
                                                      action="{{ route('leave-requests.reject', $leave) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No leave requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $leaveRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveLeave(id) {
    if (confirm('Are you sure you want to approve this leave request?')) {
        document.getElementById('approve-form-' + id).submit();
    }
}

function rejectLeave(id) {
    const reason = prompt('Please enter the reason for rejection:');
    if (reason !== null) {
        const form = document.getElementById('reject-form-' + id);
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'rejection_reason';
        reasonInput.value = reason;
        form.appendChild(reasonInput);
        form.submit();
    }
}
</script>
@endpush

@push('styles')
<style>
.btn-group .btn {
    margin-right: 2px;
}
.badge {
    text-transform: capitalize;
}
.table th {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection 