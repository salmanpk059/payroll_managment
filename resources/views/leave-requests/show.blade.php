@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Leave Request Details</h3>
                    <div>
                        @if($leaveRequest->isPending())
                            <a href="{{ route('leave-requests.edit', $leaveRequest) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit Request
                            </a>
                        @endif
                        <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Employee Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Name:</strong> {{ $leaveRequest->employee->full_name }}</p>
                                <p class="mb-1"><strong>Employee ID:</strong> {{ $leaveRequest->employee->employee_id }}</p>
                                <p class="mb-0"><strong>Department:</strong> {{ $leaveRequest->employee->department }}</p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Leave Details</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Leave Type:</strong> {{ ucfirst($leaveRequest->type) }} Leave</p>
                                <p class="mb-1"><strong>Duration:</strong> {{ $leaveRequest->total_days }} day(s)</p>
                                <p class="mb-1"><strong>Date Range:</strong> {{ $leaveRequest->formatted_date_range }}</p>
                                <p class="mb-0">
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $leaveRequest->status_badge }}">
                                        {{ ucfirst($leaveRequest->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Request Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Submitted On:</strong> {{ $leaveRequest->created_at->format('M d, Y h:i A') }}</p>
                                @if($leaveRequest->isApproved())
                                    <p class="mb-1">
                                        <strong>Approved By:</strong> 
                                        {{ $leaveRequest->approver->name ?? 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Approved On:</strong> 
                                        {{ $leaveRequest->approved_at ? $leaveRequest->approved_at->format('M d, Y h:i A') : 'N/A' }}
                                    </p>
                                @endif
                                @if($leaveRequest->isRejected() && $leaveRequest->rejection_reason)
                                    <p class="mb-0">
                                        <strong>Rejection Reason:</strong>
                                        <span class="text-danger">{{ $leaveRequest->rejection_reason }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if($leaveRequest->attachment_path)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Attachment</h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ Storage::url($leaveRequest->attachment_path) }}" 
                                       target="_blank" 
                                       class="btn btn-info">
                                        <i class="fas fa-file me-1"></i> View Attachment
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Reason for Leave</h5>
                            </div>
                            <div class="card-body">
                                {{ $leaveRequest->reason }}
                            </div>
                        </div>
                    </div>

                    @if($leaveRequest->isPending())
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" 
                                                class="btn btn-success" 
                                                onclick="approveLeave()">
                                            <i class="fas fa-check me-1"></i> Approve Request
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="rejectLeave()">
                                            <i class="fas fa-times me-1"></i> Reject Request
                                        </button>

                                        <form id="approve-form" 
                                              action="{{ route('leave-requests.approve', $leaveRequest) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <form id="reject-form" 
                                              action="{{ route('leave-requests.reject', $leaveRequest) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveLeave() {
    if (confirm('Are you sure you want to approve this leave request?')) {
        document.getElementById('approve-form').submit();
    }
}

function rejectLeave() {
    const reason = prompt('Please enter the reason for rejection:');
    if (reason !== null) {
        const form = document.getElementById('reject-form');
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
.badge {
    text-transform: capitalize;
}
.card-header.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endpush
@endsection 