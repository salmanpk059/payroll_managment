@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reports</h1>
        <div class="d-flex gap-2">
            <input type="month" id="reportMonth" class="form-control" value="{{ date('Y-m') }}">
            <button id="generateReport" class="btn btn-primary">
                <i class="fas fa-sync me-1"></i> Generate Report
            </button>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel me-1"></i> Export Reports
            </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                    <li>
                        <a class="dropdown-item" href="#" id="exportSalary">
                            <i class="fas fa-money-bill-wave me-2"></i> Export Salary Report
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" id="exportAttendance">
                            <i class="fas fa-clock me-2"></i> Export Attendance Report
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Salary Disbursed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalSalary">
                                ₨0.00
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Attendance Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="attendanceRate">
                                0%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Overtime Hours
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="overtimeHours">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Leave Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="leaveRequests">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Salary Distribution by Department</h6>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" data-chart-type="bar">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-chart-type="pie">
                            <i class="fas fa-chart-pie"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salaryDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <!-- Salary Details -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Salary Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="salaryTable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Base Salary</th>
                                    <th>Overtime</th>
                                    <th>Bonus</th>
                                    <th>Deductions</th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Details -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Present Days</th>
                                    <th>Absent Days</th>
                                    <th>Late Days</th>
                                    <th>Leave Days</th>
                                    <th>Overtime Hours</th>
                                    <th>Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Details -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Leave Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="leaveTable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .card {
        margin-bottom: 1.5rem;
    }
    .border-left-primary {
        border-left: .25rem solid #4e73df!important;
    }
    .border-left-success {
        border-left: .25rem solid #1cc88a!important;
    }
    .border-left-info {
        border-left: .25rem solid #36b9cc!important;
    }
    .border-left-warning {
        border-left: .25rem solid #f6c23e!important;
    }
    .text-xs {
        font-size: .7rem;
    }
    .card-body {
        padding: 1.25rem;
    }
    .table th {
        background-color: #f8f9fc;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let salaryChart = null;
let attendanceChart = null;
let salaryTable = null;
let attendanceTable = null;
let leaveTable = null;

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing reports page...');

    try {
    // Initialize DataTables
        console.log('Initializing DataTables...');
        salaryTable = new DataTable('#salaryTable', {
            order: [[6, 'desc']], // Sort by net salary by default
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'print']
        });

        attendanceTable = new DataTable('#attendanceTable', {
            order: [[6, 'desc']], // Sort by attendance rate by default
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'print']
        });

        leaveTable = new DataTable('#leaveTable', {
            order: [[2, 'desc']], // Sort by start date by default
        pageLength: 10,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'print']
        });

        console.log('DataTables initialized successfully');

        // Generate report on page load
        generateReport();

        // Generate report button click handler
        document.getElementById('generateReport').addEventListener('click', generateReport);

        // Export buttons click handlers
        document.getElementById('exportSalary').addEventListener('click', function(e) {
            e.preventDefault();
            const month = document.getElementById('reportMonth').value;
            window.location.href = `{{ route('reports.export.salary') }}?month=${month}`;
        });

        document.getElementById('exportAttendance').addEventListener('click', function(e) {
            e.preventDefault();
            const month = document.getElementById('reportMonth').value;
            window.location.href = `{{ route('reports.export.attendance') }}?month=${month}`;
        });

        // Chart type toggle handlers
        document.querySelectorAll('[data-chart-type]').forEach(button => {
            button.addEventListener('click', function() {
                const chartType = this.dataset.chartType;
                const buttons = this.parentElement.querySelectorAll('button');
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                updateSalaryChart(chartType);
            });
        });

        console.log('Event listeners attached successfully');
    } catch (error) {
        console.error('Error during initialization:', error);
        showError('Failed to initialize the reports page. Please refresh and try again.');
    }
});

function generateReport() {
    console.log('Generating report...');
    const month = document.getElementById('reportMonth').value;
    const button = document.getElementById('generateReport');
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Generating...';

    // Clear previous data
    clearData();

    fetch(`{{ route('reports.data') }}?month=${month}`, {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Report data received:', data);
        if (data.success) {
            updateSummaryCards(data.summary);
            updateCharts(data.charts);
            updateTables(data.details);
        } else {
            throw new Error(data.error || 'Failed to generate report');
        }
    })
    .catch(error => {
        console.error('Error generating report:', error);
        showError('Failed to generate report. Please try again.');
    })
    .finally(() => {
        // Reset button state
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-sync me-1"></i> Generate Report';
    });
}

function clearData() {
    console.log('Clearing previous data...');
    try {
        // Clear summary cards
        document.getElementById('totalSalary').textContent = '₨0.00';
        document.getElementById('attendanceRate').textContent = '0%';
        document.getElementById('overtimeHours').textContent = '0';
        document.getElementById('leaveRequests').textContent = '0';

        // Clear tables
        salaryTable.clear().draw();
        attendanceTable.clear().draw();
        leaveTable.clear().draw();

        // Clear charts
        if (salaryChart) {
            salaryChart.destroy();
        }
        if (attendanceChart) {
            attendanceChart.destroy();
        }
        console.log('Data cleared successfully');
    } catch (error) {
        console.error('Error clearing data:', error);
    }
}

function showError(message) {
    console.error('Showing error:', message);
    const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    document.querySelector('.container-fluid').insertAdjacentHTML('afterbegin', alertHtml);
}

function updateSummaryCards(summary) {
    console.log('Updating summary cards:', summary);
    try {
        document.getElementById('totalSalary').textContent = '₨' + parseFloat(summary.totalSalary).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('attendanceRate').textContent = summary.attendanceRate + '%';
        document.getElementById('overtimeHours').textContent = parseFloat(summary.overtimeHours).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('leaveRequests').textContent = summary.leaveRequests;
        console.log('Summary cards updated successfully');
    } catch (error) {
        console.error('Error updating summary cards:', error);
    }
}

function updateCharts(charts) {
    console.log('Updating charts:', charts);
    try {
        // Update salary distribution chart
        const activeChartType = document.querySelector('[data-chart-type].active').dataset.chartType;
        if (salaryChart) {
            salaryChart.destroy();
        }

        const ctx1 = document.getElementById('salaryDistributionChart').getContext('2d');
        salaryChart = new Chart(ctx1, {
            type: activeChartType,
            data: {
                labels: charts.salary.labels,
                datasets: [{
                    label: 'Total Salary',
                    data: charts.salary.data,
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(54, 185, 204, 0.8)',
                        'rgba(246, 194, 62, 0.8)',
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(231, 74, 59, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Update attendance chart
        if (attendanceChart) {
            attendanceChart.destroy();
        }

        const ctx2 = document.getElementById('attendanceChart').getContext('2d');
        attendanceChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late', 'On Leave'],
                datasets: [{
                    data: charts.attendance,
                    backgroundColor: [
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(231, 74, 59, 0.8)',
                        'rgba(246, 194, 62, 0.8)',
                        'rgba(54, 185, 204, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        console.log('Charts updated successfully');
    } catch (error) {
        console.error('Error updating charts:', error);
    }
}

    function updateTables(details) {
    console.log('Updating tables:', details);
    try {
        // Update salary table
        salaryTable.clear();
        details.salary.forEach(record => {
            salaryTable.row.add([
                record.employee,
                record.department,
                '₨' + parseFloat(record.base_salary).toLocaleString(undefined, {minimumFractionDigits: 2}),
                '₨' + parseFloat(record.overtime).toLocaleString(undefined, {minimumFractionDigits: 2}),
                '₨' + parseFloat(record.bonus).toLocaleString(undefined, {minimumFractionDigits: 2}),
                '₨' + parseFloat(record.deductions).toLocaleString(undefined, {minimumFractionDigits: 2}),
                '₨' + parseFloat(record.net_salary).toLocaleString(undefined, {minimumFractionDigits: 2})
            ]);
        });
        salaryTable.draw();

        // Update attendance table
        attendanceTable.clear();
        details.attendance.forEach(record => {
            attendanceTable.row.add([
                record.employee,
                record.present_days,
                record.absent_days,
                record.late_days,
                record.leave_days,
                parseFloat(record.overtime_hours).toFixed(2),
                parseFloat(record.attendance_rate).toFixed(2) + '%'
            ]);
        });
        attendanceTable.draw();

        // Update leave table
        leaveTable.clear();
        details.leave.forEach(record => {
            leaveTable.row.add([
                record.employee,
                record.leave_type,
                record.start_date,
                record.end_date,
                record.days,
                record.status,
                record.reason
            ]);
        });
        leaveTable.draw();
        console.log('Tables updated successfully');
    } catch (error) {
        console.error('Error updating tables:', error);
    }
}

function updateSalaryChart(type) {
    console.log('Updating salary chart type:', type);
    try {
        if (salaryChart) {
            salaryChart.config.type = type;
            salaryChart.update();
            console.log('Salary chart type updated successfully');
        }
    } catch (error) {
        console.error('Error updating salary chart type:', error);
    }
}
</script>
@endpush

@endsection