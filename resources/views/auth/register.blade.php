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

                        {{-- 1. USERNAME VÀ EMAIL --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Username<span>*</span></p>
                                    <input type="text" name="username" value="{{ old('username') }}" required>
                                    @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. MẬT KHẨU VÀ XÁC NHẬN MẬT KHẨU --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Mật khẩu<span>*</span></p>
                                    <input type="password" id="password" name="password" required>
                                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Xác nhận Mật khẩu<span>*</span></p>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        {{-- 🔥 3. TRƯỜNG CAPTCHA MỚI --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <label for="captcha">Mã xác nhận (Captcha)<span>*</span></label>
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            {{-- Hiển thị hình ảnh Captcha --}}
                                            <div class="captcha-img-box" style="border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                                {{-- SỬA DÒNG NÀY: --}}
                                                {!! captcha_img('flat') !!}
                                                {{-- Thay Captcha::img('flat') bằng captcha_img('flat') --}}
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            {{-- Nút refresh Captcha --}}
                                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary refresh-captcha" style="background: #ccc; color: #333; border: none; font-weight: 600; padding: 10px 15px;">
                                                <i class="fa fa-sync-alt"></i> Thay đổi
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Trường nhập Captcha --}}
                                    <input type="text" id="captcha" name="captcha"
                                        placeholder="Nhập mã xác nhận" required style="margin-top: 15px;">
                                    @error('captcha')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- KẾT THÚC TRƯỜNG CAPTCHA MỚI --}}


                        {{-- 4. TERMS AND CONDITIONS --}}
                        <div class="checkout__input__checkbox mb-3" style="background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #ddd;">
                            <label for="terms">
                                Tôi đồng ý với các Điều khoản & Chính sách của cửa hàng
                                <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            @error('terms')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="site-btn btn-block">CREATE ACCOUNT</button>
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
        // 🔥 CODE REFRESH CAPTCHA
        document.querySelector('.refresh-captcha')?.addEventListener('click', function(e) {
            e.preventDefault();
            // Cập nhật URL hình ảnh Captcha để tạo mới
            const captchaImgBox = document.querySelector('.captcha-img-box');
            const newUrl = '/captcha/flat?' + Math.random();
            captchaImgBox.innerHTML = '<img src="' + newUrl + '" alt="captcha">';
            document.getElementById('captcha').value = ''; // Xóa input Captcha cũ
        });
        // KẾT THÚC CODE REFRESH CAPTCHA
    });
</script>


@endsection