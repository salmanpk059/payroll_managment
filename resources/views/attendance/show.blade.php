@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Attendance Details</h3>
                    <div>
                        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Employee Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Name:</strong> {{ $attendance->employee->full_name }}</p>
                                <p class="mb-1"><strong>Employee ID:</strong> {{ $attendance->employee->employee_id }}</p>
                                <p class="mb-1"><strong>Department:</strong> {{ $attendance->employee->department }}</p>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Attendance Details</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Date:</strong> {{ $attendance->date->format('M d, Y') }}</p>
                                <p class="mb-1">
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ 
                                        $attendance->status === 'present' ? 'success' : 
                                        ($attendance->status === 'absent' ? 'danger' : 
                                        ($attendance->status === 'late' ? 'warning' : 
                                        ($attendance->status === 'half_day' ? 'info' : 'secondary'))) 
                                    }}">
                                        {{ str_replace('_', ' ', ucfirst($attendance->status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Time Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">
                                    <strong>Clock In:</strong> 
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') : 'N/A' }}
                                </p>
                                <p class="mb-1">
                                    <strong>Clock Out:</strong> 
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') : 'N/A' }}
                                </p>
                                <p class="mb-1">
                                    <strong>Working Hours:</strong> 
                                    {{ $attendance->working_hours }} hrs
                                </p>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Additional Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">
                                    <strong>Late Minutes:</strong>
                                    @if($attendance->late_minutes > 0)
                                        <span class="text-danger">{{ round($attendance->late_minutes/60, 1) }} hrs</span>
                                    @else
                                        None
                                    @endif
                                </p>
                                <p class="mb-1">
                                    <strong>Overtime:</strong>
                                    @if($attendance->overtime_minutes > 0)
                                        <span class="text-success">{{ round($attendance->overtime_minutes/60, 1) }} hrs</span>
                                    @else
                                        None
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($attendance->notes)
                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Notes</h5>
                                </div>
                                <div class="card-body">
                                    {{ $attendance->notes }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        text-transform: capitalize;
    }
    .card-body p:last-child {
        margin-bottom: 0;
    }
</style>
@endpush
@endsection 