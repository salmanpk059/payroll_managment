@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Leave Request</h3>
                    <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('leave-requests.update', $leaveRequest) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-select @error('employee_id') is-invalid @enderror" 
                                    id="employee_id" 
                                    name="employee_id" 
                                    required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" 
                                            {{ old('employee_id', $leaveRequest->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->full_name }} ({{ $employee->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label">Leave Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Select Leave Type</option>
                                <option value="annual" {{ old('type', $leaveRequest->type) == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                                <option value="sick" {{ old('type', $leaveRequest->type) == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                <option value="personal" {{ old('type', $leaveRequest->type) == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                                <option value="maternity" {{ old('type', $leaveRequest->type) == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                                <option value="paternity" {{ old('type', $leaveRequest->type) == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                                <option value="unpaid" {{ old('type', $leaveRequest->type) == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date', $leaveRequest->start_date->format('Y-m-d')) }}" 
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" 
                                   class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date', $leaveRequest->end_date->format('Y-m-d')) }}" 
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="reason" class="form-label">Reason for Leave</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" 
                                      name="reason" 
                                      rows="3" 
                                      required>{{ old('reason', $leaveRequest->reason) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="attachment" class="form-label">
                                Attachment
                                <small class="text-muted">
                                    - Accepted files: PDF, DOC, DOCX, JPG, JPEG, PNG (max: 2MB)
                                </small>
                            </label>
                            @if($leaveRequest->attachment_path)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($leaveRequest->attachment_path) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file me-1"></i> View Current Attachment
                                    </a>
                                </div>
                            @endif
                            <input type="file" 
                                   class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" 
                                   name="attachment">
                            <small class="text-muted">Upload new file to replace the current attachment</small>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Request
                            </button>
                            <a href="{{ route('leave-requests.show', $leaveRequest) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const typeSelect = document.getElementById('type');

    startDateInput.addEventListener('change', function() {
        // Set minimum date for end date based on start date
        endDateInput.min = this.value;
        
        // If end date is before start date, update it
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });

    typeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Add specific validations based on leave type
        if (selectedType === 'sick') {
            document.getElementById('attachment').setAttribute('required', 'required');
        } else {
            document.getElementById('attachment').removeAttribute('required');
        }
    });

    // Trigger type change event on load to set initial state
    typeSelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
@endsection 