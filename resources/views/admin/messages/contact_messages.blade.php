@extends('layouts.admin')

@section('title', 'Quản lý Tin nhắn Liên hệ')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Hộp thư Liên hệ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tin nhắn</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-envelope mr-1"></i>
                    Danh sách Tin nhắn (Chưa đọc: {{ $unreadCount }}) (Chưa xử lý: {{ $unhandledCount }})
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">Stt</th>
                                <th style="width: 15%">Người gửi</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 35%">Nội dung (Trích đoạn)</th>
                                <th style="width: 10%">Thời gian</th>
                                <th style="width: 5%">Đã xử lý</th>
                                <th style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr class="@if(!$message->is_read) font-weight-bold @endif">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>
                                    {{ Str::limit($message->message, 50) }}
                                </td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{-- Cột Đã xử lý --}}
                                    @if($message->is_handled)
                                    <span class="badge badge-success">Hoàn tất</span>
                                    @else
                                    <span class="badge badge-warning">Đang chờ</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- NÚT THAO TÁC --}}
                                    <form action="{{ route('admin.messages.toggle.handled', $message->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm @if($message->is_handled) btn-outline-danger @else btn-outline-success @endif"
                                            title="@if($message->is_handled) Đánh dấu Chưa xử lý @else Đánh dấu Đã xử lý @endif">
                                            <i class="fas @if($message->is_handled) fa-times @else fa-check @endif"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- ... --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</section>
@endsection