<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Department Management
Route::controller(DepartmentController::class)->group(function () {
    Route::get('/departments', 'index')->name('departments.index');
    Route::get('/departments/create', 'create')->name('departments.create');
    Route::post('/departments', 'store')->name('departments.store');
    Route::get('/departments/{department}', 'show')->name('departments.show');
    Route::get('/departments/{department}/edit', 'edit')->name('departments.edit');
    Route::put('/departments/{department}', 'update')->name('departments.update');
    Route::delete('/departments/{department}', 'destroy')->name('departments.destroy');
});

// Employee Management
Route::controller(EmployeeController::class)->group(function () {
    Route::get('/employees', 'index')->name('employees.index');
    Route::get('/employees/create', 'create')->name('employees.create');
    Route::post('/employees', 'store')->name('employees.store');
    Route::get('/employees/{employee}', 'show')->name('employees.show');
    Route::get('/employees/{employee}/edit', 'edit')->name('employees.edit');
    Route::put('/employees/{employee}', 'update')->name('employees.update');
    Route::delete('/employees/{employee}', 'destroy')->name('employees.destroy');
});

// Salary Management
Route::controller(SalaryController::class)->group(function () {
    Route::get('/salaries', 'index')->name('salaries.index');
    Route::get('/salaries/create', 'create')->name('salaries.create');
    Route::get('/salaries/report', 'report')->name('salaries.report');
    Route::post('/salaries', 'store')->name('salaries.store');
    Route::get('/salaries/{salary}', 'show')->name('salaries.show');
    Route::get('/salaries/{salary}/edit', 'edit')->name('salaries.edit');
    Route::put('/salaries/{salary}', 'update')->name('salaries.update');
    Route::delete('/salaries/{salary}', 'destroy')->name('salaries.destroy');
});

// Attendance Management
Route::controller(AttendanceController::class)->group(function () {
    Route::get('/attendance', 'index')->name('attendance.index');
    Route::get('/attendance/create', 'create')->name('attendance.create');
    Route::post('/attendance', 'store')->name('attendance.store');
    Route::get('/attendance/report', 'report')->name('attendance.report');
    Route::get('/attendance/{attendance}', 'show')->name('attendance.show');
    Route::get('/attendance/{attendance}/edit', 'edit')->name('attendance.edit');
    Route::put('/attendance/{attendance}', 'update')->name('attendance.update');
    Route::delete('/attendance/{attendance}', 'destroy')->name('attendance.destroy');
});

// Leave Request Management
Route::controller(LeaveRequestController::class)->group(function () {
    Route::get('/leave-requests', 'index')->name('leave-requests.index');
    Route::get('/leave-requests/create', 'create')->name('leave-requests.create');
    Route::post('/leave-requests', 'store')->name('leave-requests.store');
    Route::get('/leave-requests/{leaveRequest}', 'show')->name('leave-requests.show');
    Route::get('/leave-requests/{leaveRequest}/edit', 'edit')->name('leave-requests.edit');
    Route::put('/leave-requests/{leaveRequest}', 'update')->name('leave-requests.update');
    Route::delete('/leave-requests/{leaveRequest}', 'destroy')->name('leave-requests.destroy');
    Route::put('/leave-requests/{leaveRequest}/approve', 'approve')->name('leave-requests.approve');
    Route::put('/leave-requests/{leaveRequest}/reject', 'reject')->name('leave-requests.reject');
});

// Report Management
Route::controller(ReportController::class)->group(function () {
    Route::get('/reports', 'index')->name('reports.index');
    Route::get('/reports/data', 'getReportData')->name('reports.data');
        Route::get('/reports/export/salary', 'exportSalaryReport')->name('reports.export.salary');
        Route::get('/reports/export/attendance', 'exportAttendanceReport')->name('reports.export.attendance');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Help & Support Route
Route::get('/help', [HelpController::class, 'index'])->name('help');