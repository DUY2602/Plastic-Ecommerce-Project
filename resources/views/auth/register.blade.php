@extends('layouts.app')

@section('title', 'Register - PolySite')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Register</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Register</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Register Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="checkout__form">
                    <h4>Create New Account</h4>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="checkout__input">
                            <label for="username">Username<span>*</span></label>
                            <input type="text" id="username" name="username"
                                value="{{ old('username') }}"
                                placeholder="Enter your username" required>
                            @error('username')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="checkout__input">
                            <label for="email">Email Address<span>*</span></label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email" required>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="password">Password<span>*</span></label>
                                    <input type="password" id="password" name="password"
                                        placeholder="Create password (min 6 characters)" required>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="password_confirmation">Confirm Password<span>*</span></label>
                                    <input type="password" id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Confirm password" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input__checkbox mb-3" style="background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #ddd;">
                            <div style="display: flex; align-items: center; gap: 12px; margin: 0 !important;">
                                <input type="checkbox" id="terms" name="terms" required {{ old('terms') ? 'checked' : '' }}
                                    style="width: 18px !important; height: 18px !important; margin: 0 !important; display: block !important;">
                                <label for="terms" style="font-weight: 700 !important; color: #000 !important; margin: 0 !important; display: block !important; line-height: 1.4;">
                                    I agree to the <a href="#" style="font-weight: 800 !important; color: #007bff !important; text-decoration: underline;">Terms and Conditions</a> and <a href="#" style="font-weight: 800 !important; color: #007bff !important; text-decoration: underline;">Privacy Policy</a>
                                </label>
                            </div>
                            @error('terms')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="site-btn btn-block">CREATE ACCOUNT</button>

                        <div class="text-center mt-3">
                            <p>Already have an account?
                                <a href="{{ route('login') }}" class="login-link">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Register Section End -->
@endsection

@section('styles')
<style>
    /* Làm đậm chữ trong form register */
    .checkout__input label,
    .checkout__input p {
        font-weight: 700 !important;
        color: #000 !important;
        font-size: 15px;
    }

    /* Làm đậm chữ terms đặc biệt */
    .checkout__input__checkbox label {
        font-weight: 700 !important;
        color: #000 !important;
    }

    /* Làm đậm links trong terms */
    .checkout__input__checkbox a {
        font-weight: 800 !important;
        color: #007bff !important;
        text-decoration: underline;
    }

    /* Làm đậm chữ KHI ĐANG NHẬP trong input */
    .checkout__input input {
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Đảm bảo chữ đậm khi có giá trị */
    .checkout__input input,
    .checkout__input input:focus,
    .checkout__input input:not(:placeholder-shown) {
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Làm rõ placeholder */
    .checkout__input input::placeholder {
        font-weight: 500 !important;
        color: #666 !important;
        opacity: 1;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            let isValid = true;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            // Clear previous errors
            document.querySelectorAll('.text-danger').forEach(el => el.remove());

            if (password.length < 6) {
                isValid = false;
                const errorElement = document.createElement('span');
                errorElement.className = 'text-danger';
                errorElement.textContent = 'Password must be at least 6 characters long.';
                document.getElementById('password').parentNode.appendChild(errorElement);
            }

            if (password !== confirmPassword) {
                isValid = false;
                const errorElement = document.createElement('span');
                errorElement.className = 'text-danger';
                errorElement.textContent = 'Passwords do not match.';
                document.getElementById('password_confirmation').parentNode.appendChild(errorElement);
            }

            if (!terms) {
                isValid = false;
                const errorElement = document.createElement('span');
                errorElement.className = 'text-danger';
                errorElement.textContent = 'Please agree to the Terms and Conditions.';
                document.getElementById('terms').parentNode.appendChild(errorElement);
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection