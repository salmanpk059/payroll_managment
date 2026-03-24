@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fs-2 m-0">Salary Records</h2>
        <a href="{{ route('salaries.create') }}" class="btn btn-primary">Add New Salary</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('salaries.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search salaries..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('salaries.index') }}" class="btn btn-link ms-2">Clear</a>
                @endif
            </form>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: calc(100vh - 250px); overflow-y: auto;">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Basic Salary</th>
                            <th>Allowances</th>
                            <th>Deductions</th>
                            <th>Net Salary</th>
                            <th>Month</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                            <tr>
                                <td>{{ $salary->employee->employee_id }}</td>
                                <td>{{ $salary->employee->first_name }} {{ $salary->employee->last_name }}</td>
                                <td>₨{{ number_format($salary->basic_salary, 2) }}</td>
                                <td>₨{{ number_format($salary->allowances, 2) }}</td>
                                <td>₨{{ number_format($salary->deductions, 2) }}</td>
                                <td>₨{{ number_format($salary->basic_salary + $salary->allowances - $salary->deductions, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($salary->month)->format('M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $salary->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($salary->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('salaries.edit', $salary) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('salaries.destroy', $salary) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this salary record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">No salary records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #f8f9fa;
    }
</style>
@endsection 