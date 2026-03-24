@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fs-2 m-0">Departments</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">Add New Department</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('departments.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search departments..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('departments.index') }}" class="btn btn-link ms-2">Clear</a>
                @endif
            </form>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: calc(100vh - 250px); overflow-y: auto;">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Name</th>
                            <th>Manager</th>
                            <th>Employees</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr>
                                <td>
                                    <div>{{ $department->name }}</div>
                                    <small class="text-muted">{{ Str::limit($department->description, 50) }}</small>
                                </td>
                                <td>
                                    @if($department->manager)
                                        {{ $department->manager->first_name }} {{ $department->manager->last_name }}
                                    @else
                                        <span class="text-muted">No manager assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $department->employees->count() }} employees</span>
                                </td>
                                <td>₨{{ number_format($department->budget, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $department->status === 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($department->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this department?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No departments found</td>
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