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
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="first_name">First Name<span>*</span></label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="last_name">Last Name<span>*</span></label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <label for="company">Company Name <small>(Optional)</small></label>
                            <input type="text" id="company" name="company" placeholder="Enter your company name">
                        </div>

                        <div class="checkout__input">
                            <label for="email">Email Address<span>*</span></label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="checkout__input">
                            <label for="phone">Phone Number<span>*</span></label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="password">Password<span>*</span></label>
                                    <input type="password" id="password" name="password" placeholder="Create password" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="password_confirmation">Confirm Password<span>*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" placeholder="Street Address">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" placeholder="City">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" placeholder="Country">
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input__checkbox mb-3">
                            <label for="terms">
                                <input type="checkbox" id="terms" name="terms" required>
                                I agree to the <a href="#" class="terms-link">Terms and Conditions</a> and <a href="#" class="privacy-link">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="checkout__input__checkbox mb-3">
                            <label for="newsletter">
                                <input type="checkbox" id="newsletter" name="newsletter">
                                Subscribe to our newsletter for updates and offers
                            </label>
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

@section('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms').checked;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match.');
            return;
        }

        if (!terms) {
            e.preventDefault();
            alert('Please agree to the Terms and Conditions.');
            return;
        }

        if (password.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long.');
            return;
        }
    });
</script>
@endsection