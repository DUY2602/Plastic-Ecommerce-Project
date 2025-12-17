@extends('layouts.app')

@section('title', 'AI Chat Assistant - Plastic Store')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>AI Chat Assistant</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chat Interface -->
<section class="chat-section spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- API Status -->
                <div class="api-status alert alert-success">
                    ✅ <strong>Groq AI Connected</strong> - Model: llama-3.1-8b-instant
                </div>

                <!-- Quick Suggestions -->
                <div class="suggestions-container mb-4">
                    <h6 class="text-center mb-3">Quick Questions:</h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="What is the difference between PET, PP, and PC materials?">
                                <i class="fa fa-flask"></i>
                                <span>Material Differences</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Which plastic bottle is suitable for drinking water?">
                                <i class="fa fa-tint"></i>
                                <span>Water Bottles</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Which type of plastic is best for storing chemicals?">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span>Storing Chemicals</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Tell me about your sports bottle products">
                                <i class="fa fa-heartbeat"></i>
                                <span>Sports Bottles</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="chat-container">
                    <div class="chats-container" id="chatsContainer">
                        <!-- Messages will appear here -->
                    </div>

                    <!-- Input Area -->
                    <div class="prompt-container">
                        <form class="prompt-form" id="promptForm">
                            @csrf
                            <div class="input-group">
                                <input type="text" placeholder="Ask about our plastic products..."
                                    class="form-control prompt-input" id="promptInput" required>
                                <div class="input-group-append">
                                    <button type="submit" id="sendButton" class="btn btn-primary send-btn">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                    <button type="button" id="stopButton" class="btn btn-danger stop-btn" style="display: none;">
                                        <i class="fa fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <p class="disclaimer-text mt-2">AI may occasionally generate inaccurate information</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endsection