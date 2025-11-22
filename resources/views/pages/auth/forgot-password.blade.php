@extends('layouts.app')

@section('title', 'Forgot Password - PolySite')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Forgot Password</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Forgot Password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Forgot Password Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="checkout__form">
                    <h4>Reset Your Password</h4>
                    <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>

                    <form action="#">
                        <div class="checkout__input">
                            <label for="email">Email Address<span>*</span></label>
                            <input type="email" id="email" name="email" placeholder="Enter your registered email" required>
                        </div>

                        <button type="submit" class="site-btn btn-block">SEND RESET LINK</button>

                        <div class="text-center mt-3">
                            <p>Remember your password?
                                <a href="{{ route('login') }}" class="login-link">Back to Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Forgot Password Section End -->
@endsection