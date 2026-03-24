@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Process New Salary</h3>
                    <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('salaries.store') }}" method="POST" id="salaryForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-select @error('employee_id') is-invalid @enderror" 
                                    id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" 
                                            data-base-salary="{{ $employee->base_salary }}"
                                            {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->full_name }} ({{ $employee->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="salary_date" class="form-label">Salary Date</label>
                            <input type="date" class="form-control @error('salary_date') is-invalid @enderror" 
                                   id="salary_date" name="salary_date" value="{{ old('salary_date', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="base_salary" class="form-label">Base Salary</label>
                            <input type="number" step="0.01" class="form-control @error('base_salary') is-invalid @enderror" 
                                   id="base_salary" name="base_salary" value="{{ old('base_salary') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="overtime_hours" class="form-label">Overtime Hours</label>
                            <input type="number" step="0.01" class="form-control @error('overtime_hours') is-invalid @enderror" 
                                   id="overtime_hours" name="overtime_hours" value="{{ old('overtime_hours', 0) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="overtime_rate" class="form-label">Overtime Rate (per hour)</label>
                            <input type="number" step="0.01" class="form-control @error('overtime_rate') is-invalid @enderror" 
                                   id="overtime_rate" name="overtime_rate" value="{{ old('overtime_rate', 0) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="overtime_pay" class="form-label">Overtime Pay (calculated)</label>
                            <input type="number" step="0.01" class="form-control" 
                                   id="overtime_pay" name="overtime_pay" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="bonus" class="form-label">Bonus</label>
                            <input type="number" step="0.01" class="form-control @error('bonus') is-invalid @enderror" 
                                   id="bonus" name="bonus" value="{{ old('bonus', 0) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="allowances" class="form-label">Allowances</label>
                            <input type="number" step="0.01" class="form-control @error('allowances') is-invalid @enderror" 
                                   id="allowances" name="allowances" value="{{ old('allowances', 0) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="deductions" class="form-label">Deductions</label>
                            <input type="number" step="0.01" class="form-control @error('deductions') is-invalid @enderror" 
                                   id="deductions" name="deductions" value="{{ old('deductions', 0) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" name="payment_method" required>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" 
                                    id="payment_status" name="payment_status" required>
                                <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ old('payment_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Salary Summary</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Gross Salary:</strong></p>
                                            <h4 class="text-primary">₨<span id="gross_salary">0.00</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Tax:</strong></p>
                                            <h4 class="text-danger">₨<span id="tax_amount">0.00</span></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Net Salary:</strong></p>
                                            <h4 class="text-success">₨<span id="net_salary">0.00</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Process Salary
                            </button>
                            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
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
    const employeeSelect = document.getElementById('employee_id');
    const baseSalaryInput = document.getElementById('base_salary');
    const overtimeHoursInput = document.getElementById('overtime_hours');
    const overtimeRateInput = document.getElementById('overtime_rate');
    const overtimePayInput = document.getElementById('overtime_pay');
    const bonusInput = document.getElementById('bonus');
    const allowancesInput = document.getElementById('allowances');
    const deductionsInput = document.getElementById('deductions');
    const grossSalaryDisplay = document.getElementById('gross_salary');
    const taxAmountDisplay = document.getElementById('tax_amount');
    const netSalaryDisplay = document.getElementById('net_salary');

    // Function to calculate and update all values
    function updateCalculations() {
        // Get values
        const baseSalary = parseFloat(baseSalaryInput.value) || 0;
        const overtimeHours = parseFloat(overtimeHoursInput.value) || 0;
        const overtimeRate = parseFloat(overtimeRateInput.value) || 0;
        const bonus = parseFloat(bonusInput.value) || 0;
        const allowances = parseFloat(allowancesInput.value) || 0;
        const deductions = parseFloat(deductionsInput.value) || 0;

        // Calculate overtime pay
        const overtimePay = overtimeHours * overtimeRate;
        overtimePayInput.value = overtimePay.toFixed(2);

        // Calculate gross salary
        const grossSalary = baseSalary + overtimePay + bonus + allowances;
        grossSalaryDisplay.textContent = grossSalary.toFixed(2);

        // Calculate tax (simplified progressive tax)
        let tax = 0;
        if (grossSalary <= 1000) {
            tax = grossSalary * 0.1;
        } else if (grossSalary <= 5000) {
            tax = 1000 * 0.1 + (grossSalary - 1000) * 0.15;
        } else {
            tax = 1000 * 0.1 + 4000 * 0.15 + (grossSalary - 5000) * 0.2;
        }
        taxAmountDisplay.textContent = tax.toFixed(2);

        // Calculate net salary
        const netSalary = grossSalary - tax - deductions;
        netSalaryDisplay.textContent = netSalary.toFixed(2);
    }

    // Set up event listeners
    employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            baseSalaryInput.value = selectedOption.dataset.baseSalary;
            updateCalculations();
        } else {
            baseSalaryInput.value = '';
            updateCalculations();
        }
    });

    // Add event listeners to all input fields that affect calculations
    [baseSalaryInput, overtimeHoursInput, overtimeRateInput, bonusInput, 
     allowancesInput, deductionsInput].forEach(input => {
        input.addEventListener('input', updateCalculations);
    });

    // Initial calculation
    updateCalculations();
});
</script>
@endpush
@endsection