@extends('layouts.app')

@section('title', 'Admin Login')

@section('styles')
<style>
    .admin-login-section {
        background: linear-gradient(-45deg, #667eea, #764ba2, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 50px 0;
        position: relative;
        overflow: hidden;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .admin-login-card {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 2;
        overflow: hidden;
    }

    .admin-login-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .admin-login-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 35px 70px rgba(0, 0, 0, 0.5);
    }

    .admin-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        z-index: 3;
    }

    .admin-icon {
        font-size: 52px;
        color: #3498db;
        margin-bottom: 20px;
        display: block;
        text-shadow: 0 5px 15px rgba(52, 152, 219, 0.5);
    }

    .admin-title {
        font-size: 32px;
        font-weight: 800;
        color: #ecf0f1;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .admin-subtitle {
        color: #bdc3c7;
        font-size: 16px;
        font-weight: 500;
    }

    .form-group {
        position: relative;
        margin-bottom: 30px;
        z-index: 3;
    }

    .form-control {
        border: 2px solid #34495e;
        border-radius: 15px;
        padding: 18px 25px 18px 50px;
        font-size: 16px;
        font-weight: 600;
        color: #ffffff !important;
        transition: all 0.3s ease;
        background: rgba(52, 73, 94, 0.8);
        color: #ecf0f1;
        backdrop-filter: blur(10px);
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.3);
        transform: translateY(-3px);
        background: rgba(44, 62, 80, 0.9);
    }

    .form-control::placeholder {
        color: #95a5a6;
    }

    .form-label {
        position: absolute;
        left: 50px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 0 10px;
        color: #95a5a6;
        transition: all 0.3s ease;
        pointer-events: none;
        font-weight: 500;
    }

    .form-control:focus+.form-label,
    .form-control:not(:placeholder-shown)+.form-label {
        top: 0;
        font-size: 13px;
        color: #3498db;
        font-weight: 700;
        transform: translateY(-50%) scale(0.9);
    }

    .btn-admin {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
        border-radius: 15px;
        padding: 18px 30px;
        font-size: 17px;
        font-weight: 700;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        letter-spacing: 0.5px;
        z-index: 3;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn-admin:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(52, 152, 219, 0.4);
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
    }

    .btn-admin:active {
        transform: translateY(-1px);
    }

    .btn-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .btn-admin:hover::before {
        left: 100%;
    }

    .admin-links {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        z-index: 3;
    }

    .admin-link {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 15px;
        /* REMOVED FADE EFFECT - keep only color change */
        opacity: 1 !important;
    }

    .admin-link:hover {
        color: #ecf0f1;
        text-decoration: none;
        /* REMOVED MOVEMENT EFFECT */
        transform: none;
    }

    .input-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
        z-index: 2;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .form-control:focus~.input-icon {
        color: #3498db;
        transform: translateY(-50%) scale(1.1);
    }

    .alert {
        border-radius: 15px;
        border: none;
        padding: 18px 25px;
        margin-bottom: 25px;
        animation: slideInDown 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-weight: 500;
        position: relative;
        z-index: 3;
    }

    .alert-danger {
        background: rgba(231, 76, 60, 0.9);
        color: #ecf0f1;
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.9);
        color: #ecf0f1;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Subtle particles effect */
    .particles-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .particle:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .particle:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        left: 80%;
        animation-delay: 2s;
    }

    .particle:nth-child(3) {
        width: 60px;
        height: 60px;
        top: 80%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg) scale(1);
            opacity: 0.5;
        }

        50% {
            transform: translateY(-15px) rotate(180deg) scale(1.1);
            opacity: 0.8;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-login-card {
            padding: 40px 25px;
            margin: 20px;
        }

        .admin-title {
            font-size: 28px;
        }

        .admin-icon {
            font-size: 45px;
        }
    }
</style>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('adminLoginForm');
        const loginBtn = document.getElementById('loginBtn');

        // Input effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            if (input.value) {
                input.parentElement.classList.add('focused');
            }

            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Form submit effect
        form.addEventListener('submit', function(e) {
            loginBtn.style.transform = 'scale(0.98)';
            setTimeout(() => {
                loginBtn.style.transform = '';
            }, 150);
        });

        // Page load effect for card
        const card = document.querySelector('.admin-login-card');
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px) scale(0.9)';

        setTimeout(() => {
            card.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        }, 100);
    });
</script>
@endsection