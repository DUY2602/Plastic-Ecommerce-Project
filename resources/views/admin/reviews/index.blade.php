@extends('layouts.admin')

@section('title', 'Product Reviews')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-star text-warning mr-2"></i>
                    Product Reviews
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
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
                        <h3>{{ number_format($stats['total']) }}</h3>
                        <p>Total Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($stats['average_rating'], 1) }}/5</h3>
                        <p>Average Rating</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($stats['five_star']) }}</h3>
                        <p>5-Star Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ number_format($stats['today']) }}</h3>
                        <p>Today's Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Reviews</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default">Filter</button>
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?rating=5">5 Stars</a>
                                    <a class="dropdown-item" href="?rating=4">4 Stars</a>
                                    <a class="dropdown-item" href="?rating=3">3 Stars</a>
                                    <a class="dropdown-item" href="?rating=2">2 Stars</a>
                                    <a class="dropdown-item" href="?rating=1">1 Star</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="?">All Reviews</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Product</th>
                                    <th width="15%">User</th>
                                    <th width="10%">Rating</th>
                                    <th width="30%">Comment</th>
                                    <th width="15%">Date</th>
                                    <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>{{ $review->FeedbackID }}</td>
                                    <td>
                                        @if($review->product)
                                        <strong>{{ $review->product->ProductName }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $review->ProductID }}</small>
                                        @else
                                        <span class="text-danger">Product Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($review->user)
                                        <strong>{{ $review->user->Username }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $review->user->Email }}</small>
                                        @else
                                        <span class="text-muted">Anonymous</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->Rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="badge badge-{{ $review->Rating >= 4 ? 'success' : ($review->Rating >= 3 ? 'warning' : 'danger') }}">
                                                    {{ $review->Rating }}/5
                                                </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->Comment)
                                        <div class="comment-text">
                                            {{ \Illuminate\Support\Str::limit($review->Comment, 100) }}
                                            @if(strlen($review->Comment) > 100)
                                            <a href="#" class="text-primary" data-toggle="modal" data-target="#commentModal{{ $review->FeedbackID }}">
                                                Read more
                                            </a>
                                            @endif
                                        </div>
                                        @else
                                        <span class="text-muted">No comment</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($review->SubmissionDate)->format('d/m/Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($review->SubmissionDate)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($review->product)
                                            <a href="{{ route('admin.products.show', $review->product->ProductID) }}"
                                                class="btn btn-info" title="View Product">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endif
                                            <button class="btn btn-secondary" disabled title="View Only">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal for full comment -->
                                @if($review->Comment && strlen($review->Comment) > 100)
                                <div class="modal fade" id="commentModal{{ $review->FeedbackID }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Review Comment</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $review->Comment }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $reviews->links() }}
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary float-right">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/reviews/index.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/reviews/index.css') }}">
@endsection