@extends('layouts.app')

@section('title', 'Login - PolySite')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Login</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Login Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="checkout__form">
                    <h4>Login to Your Account</h4>
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <label for="email">Email Address<span>*</span></label>
                                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <label for="password">Password<span>*</span></label>
                                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input__checkbox mb-3">
                            <label for="remember">
                                <input type="checkbox" id="remember" name="remember">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="site-btn btn-block">LOGIN</button>

                        <div class="text-center mt-4">
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot your password?</a>
                        </div>

                        <div class="text-center mt-3">
                            <p>Don't have an account?
                                <a href="{{ route('register') }}" class="register-link">Register here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->
@endsection

@section('scripts')
<script>
    // Custom validation có thể thêm sau
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
</script>
@endsection