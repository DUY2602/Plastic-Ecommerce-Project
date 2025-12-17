@extends('layouts.app')

@section('title', 'Admin Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth/admin-login.css') }}">
@endsection

@section('content')
<!-- Admin Login Section -->
<section class="admin-login-section">
    <div class="particles-container">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="admin-login-card">
                    <div class="admin-header">
                        <i class="fas fa-user-shield admin-icon"></i>
                        <h1 class="admin-title">Administration System</h1>
                        <p class="admin-subtitle">Login to access dashboard</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}" id="adminLoginForm">
                        @csrf

                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder=" "
                                required
                                autofocus>
                            <label class="form-label">Admin Email</label>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder=" "
                                required>
                            <label class="form-label">Password</label>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-admin" id="loginBtn">
                            <span class="btn-text">LOGIN TO SYSTEM</span>
                        </button>
                    </form>

                    @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="admin-links">
                        <p style="color: #bdc3c7;">Regular user?
                            <a href="{{ route('login') }}" class="admin-link">
                                <i class="fas fa-arrow-right"></i> Login here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/auth/admin-login.js') }}"></script>
@endsection