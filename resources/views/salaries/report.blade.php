@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Salary Reports</h1>
        <div class="d-flex gap-2">
            <input type="month" class="form-control" id="reportMonth" value="{{ date('Y-m') }}">
            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Net Salary
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₨{{ number_format($monthlyTotals->sum('total_net') ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Employees Paid
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $departmentTotals->sum('employee_count') ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Average Salary
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₨{{ number_format($departmentTotals->avg('avg_salary') ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Departments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $departmentTotals->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Salary Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlySalaryChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Department Salary Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="departmentSalaryChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <!-- Monthly Summary Table -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Salary Summary</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="monthlySummaryTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Total Records</th>
                                    <th>Base Salary</th>
                                    <th>Overtime</th>
                                    <th>Bonus</th>
                                    <th>Allowances</th>
                                    <th>Deductions</th>
                                    <th>Tax</th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monthlyTotals as $total)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $total->month)->format('M Y') }}</td>
                                        <td>{{ $total->count }}</td>
                                        <td>₨{{ number_format($total->total_base ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_overtime ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_bonus ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_allowances ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_deductions ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_tax ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($total->total_net ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No salary records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Summary Table -->
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Department Salary Summary</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="departmentSummaryTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Department</th>
                                    <th>Total Employees</th>
                                    <th>Average Salary</th>
                                    <th>Total Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departmentTotals as $dept)
                                    <tr>
                                        <td>{{ $dept->department }}</td>
                                        <td>{{ $dept->employee_count }}</td>
                                        <td>₨{{ number_format($dept->avg_salary ?? 0, 2) }}</td>
                                        <td>₨{{ number_format($dept->total_net_salary ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No department data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
.card {
    margin-bottom: 1.5rem;
}
.table thead th {
    vertical-align: middle;
    border-bottom: 2px solid #e3e6f0;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}
.text-xs {
    font-size: .7rem;
}
.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    $('#monthlySummaryTable, #departmentSummaryTable').DataTable({
        pageLength: 10,
        order: [[0, 'desc']],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        language: {
            search: "",
            searchPlaceholder: "Search records..."
        }
    });

    // Monthly Salary Trend Chart
    const monthlyData = @json($monthlyTotals);
    new Chart(document.getElementById('monthlySalaryChart'), {
        type: 'line',
        data: {
            labels: monthlyData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'Net Salary',
                data: monthlyData.map(item => item.total_net || 0),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₨' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Department Salary Distribution Chart
    const departmentData = @json($departmentTotals);
    new Chart(document.getElementById('departmentSalaryChart'), {
        type: 'doughnut',
        data: {
            labels: departmentData.map(item => item.department),
            datasets: [{
                data: departmentData.map(item => item.total_net_salary || 0),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            },
            cutout: '60%'
        }
    });
});
</script>
@endpush

@endsection 