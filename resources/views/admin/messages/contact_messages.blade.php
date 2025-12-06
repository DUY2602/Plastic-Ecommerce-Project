@extends('layouts.admin')

@section('title', 'Manage Contact Messages')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Contact Inbox</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Messages</li>
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
                    Messages List (Unread: {{ $unreadCount }}) (Pending: {{ $unhandledCount }})
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">Sender</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 35%">Content (Excerpt)</th>
                                <th style="width: 10%">Time</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 10%">Actions</th>
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
                                <td>{{ $message->created_at->format('m/d/Y H:i') }}</td>
                                <td>
                                    @if($message->is_handled)
                                    <span class="badge badge-success">Completed</span>
                                    @else
                                    <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.messages.toggle.handled', $message->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm @if($message->is_handled) btn-outline-danger @else btn-outline-success @endif"
                                            title="@if($message->is_handled) Mark as Pending @else Mark as Completed @endif">
                                            <i class="fas @if($message->is_handled) fa-times @else fa-check @endif"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No messages yet</h5>
                                    <p class="text-muted">Your contact inbox is empty.</p>
                                </td>
                            </tr>
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

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .card-outline {
        border-top: 3px solid #007bff;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection