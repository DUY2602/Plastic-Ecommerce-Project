@extends('layouts.app')

@section('title', 'Account Information')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Account Information</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Account</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa fa-user-circle fa-5x text-secondary"></i>
                        </div>
                        <h5 class="card-title">{{ Auth::user()->Username }}</h5>
                        <p class="text-muted">{{ Auth::user()->Email }}</p>
                        <p class="badge badge-success mb-3">Member</p>

                        <div class="mt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Username</p>
                                        <input type="text" value="{{ Auth::user()->Username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email</p>
                                        <input type="email" value="{{ Auth::user()->Email }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Role</p>
                                        <input type="text" value="{{ Auth::user()->Role == 1 ? 'Administrator' : 'Customer' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Status</p>
                                        <input type="text" value="{{ Auth::user()->Status == 1 ? 'Active' : 'Locked' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Join Date</p>
                                <input type="text" value="{{ date('d/m/Y H:i', strtotime(Auth::user()->CreatedAt)) }}" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection