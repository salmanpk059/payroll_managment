@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if(isset($error))
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Employees</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployees ?? 0 }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-users"></i> Active Employees
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Present Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presentToday ?? 0 }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-check"></i> Today's Attendance
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Leaves</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingLeaves ?? 0 }}</div>
                            <div class="mt-2 text-warning small">
                                <i class="fas fa-calendar"></i> Leave Requests
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Departments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDepartments ?? 0 }}</div>
                            <div class="mt-2 text-info small">
                                <i class="fas fa-building"></i> Active Departments
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Department Stats -->
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Recent Activity</h6>
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('reports.index') }}">View All Activities</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities ?? [] as $activity)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @switch($activity['type'] ?? '')
                                                    @case('employee')
                                                        <i class="fas fa-user-plus text-success me-2"></i>
                                                        @break
                                                    @case('leave')
                                                        <i class="fas fa-calendar-alt text-warning me-2"></i>
                                                        @break
                                                    @case('salary')
                                                        <i class="fas fa-money-bill-wave text-info me-2"></i>
                                                        @break
                                                    @case('attendance')
                                                        <i class="fas fa-clock text-primary me-2"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-bell text-secondary me-2"></i>
                                                @endswitch
                                            </div>
                                        </td>
                                        <td>{{ $activity['title'] ?? 'Unknown' }}</td>
                                        <td>{{ $activity['description'] ?? '' }}</td>
                                        <td>{{ isset($activity['created_at']) ? $activity['created_at']->diffForHumans() : '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No recent activities</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('employees.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Add New Employee
                        </a>
                        <a href="{{ route('attendance.create') }}" class="btn btn-info text-white">
                            <i class="fas fa-clock me-2"></i>Mark Attendance
                        </a>
                        <a href="{{ route('leave-requests.create') }}" class="btn btn-warning text-white">
                            <i class="fas fa-calendar-plus me-2"></i>Create Leave Request
                        </a>
                        <a href="{{ route('reports.index') }}" class="btn btn-success">
                            <i class="fas fa-file-alt me-2"></i>Generate Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Department Stats -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Department Overview</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($departmentStats ?? [] as $dept)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $dept['name'] ?? 'Unknown Department' }}</h6>
                                    <span class="badge bg-primary">{{ $dept['employee_count'] ?? 0 }}</span>
                                </div>
                                <p class="mb-1 text-muted small">Budget: ₨{{ number_format($dept['budget'] ?? 0) }}</p>
                            </div>
                        @empty
                            <div class="list-group-item">No departments found</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection