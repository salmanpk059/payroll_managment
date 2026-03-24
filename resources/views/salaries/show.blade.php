@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Salary Details</h3>
                    <div>
                        <a href="{{ route('salaries.edit', $salary) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
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
                                <table class="table">
                                    <tr>
                                        <th width="30%">Employee ID</th>
                                        <td>{{ $salary->employee->employee_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $salary->employee->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>{{ $salary->employee->department->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Position</th>
                                        <td>{{ $salary->employee->position }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Salary Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th width="30%">Salary Date</th>
                                        <td>{{ $salary->salary_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-{{ $salary->status === 'paid' ? 'success' : ($salary->status === 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($salary->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>{{ str_replace('_', ' ', ucfirst($salary->payment_method)) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Salary Breakdown</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Component</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Base Salary</td>
                                                <td>₨{{ number_format($salary->base_salary, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Overtime Pay</td>
                                                <td>₨{{ number_format($salary->overtime_pay, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bonus</td>
                                                <td>₨{{ number_format($salary->bonus, 2) }}</td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td>Deductions</td>
                                                <td>₨{{ number_format($salary->deductions, 2) }}</td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td>Tax</td>
                                                <td>₨{{ number_format($salary->tax, 2) }}</td>
                                            </tr>
                                            <tr class="table-success fw-bold">
                                                <td>Net Salary</td>
                                                <td>₨{{ number_format($salary->net_salary, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($salary->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Notes</h5>
                                </div>
                                <div class="card-body">
                                    {{ $salary->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        text-transform: capitalize;
    }
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endpush
@endsection 