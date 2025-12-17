@extends('layouts.admin')

@section('title', 'Visitor Statistics')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-chart-line text-primary mr-2"></i>
                    Visitor Statistics
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Visitors</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($todayVisitors) }}</h3>
                        <p>Today's Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($monthVisitors) }}</h3>
                        <p>This Month</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($totalVisitors) }}</h3>
                        <p>Total Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $visitorStats->count() }}</h3>
                        <p>Days Tracked</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-database"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitor Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-2"></i>Visitor Data (Last 30 Days)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Visitors</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitorStats as $stat)
                                @php
                                $date = \Carbon\Carbon::parse($stat->date);
                                $isToday = $date->isToday();
                                $isWeekend = $date->isWeekend();
                                @endphp
                                <tr class="{{ $isToday ? 'table-info' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $date->format('d/m/Y') }}</strong>
                                        @if($isToday)
                                        <span class="badge bg-success ml-2">Today</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ number_format($stat->count) }}</span>
                                    </td>
                                    <td>
                                        {{ $date->format('l') }}
                                        @if($isWeekend)
                                        <span class="badge bg-warning ml-2">Weekend</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($stat->count >= 5)
                                        <span class="badge bg-success">High</span>
                                        @elseif($stat->count >= 3)
                                        <span class="badge bg-warning">Medium</span>
                                        @else
                                        <span class="badge bg-danger">Low</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/visitors/index.css') }}">
@endsection