@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title mb-0">My Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Picture -->
                        <div class="col-md-4 text-center mb-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=random" 
                                 class="rounded-circle img-thumbnail mb-3" 
                                 alt="Profile Picture">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>

                        <!-- Profile Information -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Personal Information</h5>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Full Name</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Email</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Phone</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $user->phone ?? 'Not set' }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            {{ $user->address ?? 'Not set' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Account Settings</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('profile.settings') }}" class="btn btn-primary btn-block w-100 mb-3">
                                                <i class="fas fa-cog me-2"></i> Edit Profile
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('profile.password') }}" class="btn btn-secondary btn-block w-100 mb-3">
                                                <i class="fas fa-key me-2"></i> Change Password
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 