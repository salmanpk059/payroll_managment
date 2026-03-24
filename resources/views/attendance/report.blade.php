@extends('layouts.app')

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .progress {
        height: 20px;
    }
    .progress-bar {
        line-height: 20px;
    }
    .table th {
        background-color: #f8f9fc;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Attendance Report</h1>
        <div class="d-flex gap-2">
            <input type="month" id="reportMonth" class="form-control" value="{{ date('Y-m') }}">
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Attendance
            </a>
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
                                Present Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $latestStats = $monthlyStats->first();
                                    $presentRate = $latestStats && $latestStats->total_records > 0
                                        ? round(($latestStats->total_present / $latestStats->total_records) * 100, 1)
                                        : 0;
                                @endphp
                                {{ $presentRate }}%
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Overtime Hours
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $latestStats ? round($latestStats->total_overtime_minutes/60, 1) : 0 }} hrs
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
                                Late Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $lateRate = $latestStats && $latestStats->total_records > 0
                                        ? round(($latestStats->total_late / $latestStats->total_records) * 100, 1)
                                        : 0;
                                @endphp
                                {{ $lateRate }}%
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Absent Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $absentRate = $latestStats && $latestStats->total_records > 0
                                        ? round(($latestStats->total_absent / $latestStats->total_records) * 100, 1)
                                        : 0;
                                @endphp
                                {{ $absentRate }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                                Average Working Hours
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $avgWorkingHours = $latestStats && $latestStats->total_records > 0
                                        ? round(8 - ($latestStats->total_late_minutes / 60 / $latestStats->total_records) + ($latestStats->total_overtime_minutes / 60 / $latestStats->total_records), 1)
                                        : 0;
                                @endphp
                                {{ $avgWorkingHours }} hrs
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-business-time fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Charts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Distribution</h6>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" data-chart-type="pie">
                            <i class="fas fa-chart-pie"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-chart-type="doughnut">
                            <i class="fas fa-circle-notch"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="attendanceDistributionChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Late vs Overtime Hours</h6>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" data-chart-type="bar">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-chart-type="line">
                            <i class="fas fa-chart-line"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="hoursComparisonChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Monthly Statistics</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="monthlyStatsTable">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Records</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Half Day</th>
                            <th>On Leave</th>
                            <th>Total Late Hours</th>
                            <th>Total Overtime Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyStats as $stat)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stat->month . '-01')->format('M Y') }}</td>
                                <td>{{ $stat->total_records }}</td>
                                <td class="text-success">{{ $stat->total_present }}</td>
                                <td class="text-danger">{{ $stat->total_absent }}</td>
                                <td class="text-warning">{{ $stat->total_late }}</td>
                                <td class="text-info">{{ $stat->total_half_day }}</td>
                                <td class="text-secondary">{{ $stat->total_on_leave }}</td>
                                <td>{{ round(($stat->total_late_minutes ?? 0)/60, 1) }} hrs</td>
                                <td>{{ round(($stat->total_overtime_minutes ?? 0)/60, 1) }} hrs</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No statistics available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Employee Statistics -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Employee Statistics (Current Month)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="employeeStatsTable">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Total Records</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Late Hours</th>
                            <th>Overtime Hours</th>
                            <th>Attendance Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employeeStats as $stat)
                            <tr>
                                <td>{{ $stat->first_name }} {{ $stat->last_name }}</td>
                                <td>{{ $stat->total_records }}</td>
                                <td class="text-success">{{ $stat->total_present }}</td>
                                <td class="text-danger">{{ $stat->total_absent }}</td>
                                <td class="text-warning">{{ $stat->total_late }}</td>
                                <td>{{ round(($stat->total_late_minutes ?? 0)/60, 1) }} hrs</td>
                                <td>{{ round(($stat->total_overtime_minutes ?? 0)/60, 1) }} hrs</td>
                                <td>
                                    @php
                                        $attendanceRate = $stat->total_records > 0 
                                            ? round(($stat->total_present / $stat->total_records) * 100, 1) 
                                            : 0;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar bg-{{ $attendanceRate >= 90 ? 'success' : ($attendanceRate >= 75 ? 'warning' : 'danger') }}" 
                                             role="progressbar" 
                                             style="width: {{ $attendanceRate }}%" 
                                             aria-valuenow="{{ $attendanceRate }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ $attendanceRate }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No employee statistics available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables with error handling
    try {
        $('#monthlyStatsTable').DataTable({
            pageLength: 10,
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            }
        });

        $('#employeeStatsTable').DataTable({
            pageLength: 10,
            order: [[7, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            }
        });
    } catch (error) {
        console.error('Error initializing DataTables:', error);
    }

    // Prepare data for charts with error handling
    try {
        const monthlyStats = @json($monthlyStats);
        const latestMonth = monthlyStats[0] || {
            total_present: 0,
            total_absent: 0,
            total_late: 0,
            total_half_day: 0,
            total_on_leave: 0,
            total_late_minutes: 0,
            total_overtime_minutes: 0
        };

        let attendanceChart = null;
        let hoursChart = null;

        // Function to update attendance distribution chart
        function updateAttendanceChart(type = 'pie') {
            const ctx = document.getElementById('attendanceDistributionChart');
            if (!ctx) {
                console.error('Cannot find attendance distribution chart canvas');
                return;
            }

            if (attendanceChart) {
                attendanceChart.destroy();
            }

            attendanceChart = new Chart(ctx, {
                type: type,
                data: {
                    labels: ['Present', 'Absent', 'Late', 'Half Day', 'On Leave'],
                    datasets: [{
                        data: [
                            latestMonth.total_present || 0,
                            latestMonth.total_absent || 0,
                            latestMonth.total_late || 0,
                            latestMonth.total_half_day || 0,
                            latestMonth.total_on_leave || 0
                        ],
                        backgroundColor: [
                            '#28a745',
                            '#dc3545',
                            '#ffc107',
                            '#17a2b8',
                            '#6c757d'
                        ]
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
        }

        // Function to update hours comparison chart
        function updateHoursChart(type = 'bar') {
            const ctx = document.getElementById('hoursComparisonChart');
            if (!ctx) {
                console.error('Cannot find hours comparison chart canvas');
                return;
            }

            if (hoursChart) {
                hoursChart.destroy();
            }

            const months = monthlyStats.map(stat => {
                const date = new Date(stat.month + '-01');
                return date.toLocaleDateString('default', { month: 'short', year: 'numeric' });
            }).reverse();

            const lateHours = monthlyStats.map(stat => (stat.total_late_minutes || 0) / 60).reverse();
            const overtimeHours = monthlyStats.map(stat => (stat.total_overtime_minutes || 0) / 60).reverse();

            hoursChart = new Chart(ctx, {
                type: type,
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Late Hours',
                            data: lateHours,
                            backgroundColor: 'rgba(255, 193, 7, 0.5)',
                            borderColor: '#ffc107',
                            borderWidth: 1
                        },
                        {
                            label: 'Overtime Hours',
                            data: overtimeHours,
                            backgroundColor: 'rgba(23, 162, 184, 0.5)',
                            borderColor: '#17a2b8',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hours'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Initialize charts
        updateAttendanceChart('pie');
        updateHoursChart('bar');

        // Add event listeners for chart type toggles
        document.querySelectorAll('[data-chart-type]').forEach(button => {
            button.addEventListener('click', function() {
                const chartType = this.getAttribute('data-chart-type');
                const chartGroup = this.closest('.btn-group');
                
                // Remove active class from all buttons in the group
                chartGroup.querySelectorAll('.btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Update the appropriate chart
                if (chartGroup.closest('.card').querySelector('#attendanceDistributionChart')) {
                    updateAttendanceChart(chartType);
                } else if (chartGroup.closest('.card').querySelector('#hoursComparisonChart')) {
                    updateHoursChart(chartType);
                }
            });
        });

        // Add month change handler
        const monthInput = document.getElementById('reportMonth');
        if (monthInput) {
            monthInput.addEventListener('change', function() {
                window.location.href = `${window.location.pathname}?month=${this.value}`;
            });
        }
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
});
</script>
@endpush