<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PayRoll System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    @stack('styles')
    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 60px;
            --primary-blue: #0d6efd;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            height: var(--navbar-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background: #2c3e50;
            padding: 0 1rem;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            padding: 0;
            margin: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            z-index: 1020;
        }

        .sidebar .nav-link {
            padding: 0.8rem 1.25rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #e9ecef;
            color: var(--primary-blue);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            min-height: calc(100vh - var(--navbar-height));
            background: #f4f6f9;
            padding: 1.5rem;
            overflow-y: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Card Styles */
        .card {
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #edf2f7;
            padding: 1rem;
        }

        /* Table Styles */
        .table-responsive {
            background: white;
            border-radius: 0.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    @auth
        <!-- Navbar -->
        <nav class="navbar">
        <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-building me-2"></i>
                    PayRoll System
                </a>
                <div class="d-flex align-items-center">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link text-white position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                                <span class="visually-hidden">unread notifications</span>
                            </span>
            </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="width: 300px;">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="text-primary me-2"><i class="fas fa-user-clock"></i></span>
                                    <div>
                                        <p class="mb-0">New leave request from John Doe</p>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="text-success me-2"><i class="fas fa-money-bill-wave"></i></span>
                                    <div>
                                        <p class="mb-0">Salary processed for May 2024</p>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="text-warning me-2"><i class="fas fa-clock"></i></span>
                                    <div>
                                        <p class="mb-0">Attendance report ready</p>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                        </a>
                    </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-center" href="#">
                                    <small>View All Notifications</small>
                        </a>
                    </li>
                        </ul>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link text-white dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                                 class="rounded-circle me-2" 
                                 alt="Profile" 
                                 width="32" 
                                 height="32">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-item text-muted">
                                    <small>Signed in as</small><br>
                                    <strong>{{ Auth::user()->email }}</strong>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle me-2"></i> My Profile
                        </a>
                    </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.settings') }}">
                                    <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.password') }}">
                                    <i class="fas fa-key me-2"></i> Change Password
                        </a>
                    </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('help') }}">
                                    <i class="fas fa-question-circle me-2"></i> Help & Support
                        </a>
                    </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                    </li>
                </ul>
                    </div>
            </div>
        </div>
    </nav>

        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                    <i class="fas fa-building"></i>
                    Departments
                </a>
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                    <i class="fas fa-users"></i>
                    Employees
                </a>
                    <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-clock"></i>
                        Attendance
                    </a>
                <a class="nav-link {{ request()->routeIs('salaries.*') ? 'active' : '' }}" href="{{ route('salaries.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    Salaries
                </a>
                    <a class="nav-link {{ request()->routeIs('leave-requests.*') ? 'active' : '' }}" href="{{ route('leave-requests.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    Leave Requests
                    </a>
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="fas fa-chart-bar"></i>
                        Reports
                    </a>
        </nav>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    @else
        <!-- Guest Content -->
        <main>
            @yield('content')
        </main>
    @endauth

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <!-- CSRF Token for AJAX Requests -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 