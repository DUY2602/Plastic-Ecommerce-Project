@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Đăng nhập</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Đăng nhập</span>
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
                    <h4>Đăng nhập tài khoản</h4>

                    {{-- Hiển thị lỗi chung --}}
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Hiển thị thông báo thành công --}}
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                        class="@error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Mật khẩu<span>*</span></p>
                                    <input type="password" name="password" required
                                        class="@error('password') is-invalid @enderror">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="site-btn">ĐĂNG NHẬP</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Chưa có tài khoản? <a href="#" class="text-primary">Liên hệ quản trị viên</a></p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->
@endsection