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
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Chat Assistant</span>
                    </div>
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
                    <h6 class="text-center mb-3">Câu hỏi nhanh:</h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Sự khác biệt giữa vật liệu PET, PP và PC là gì?">
                                <i class="fa fa-flask"></i>
                                <span>Khác biệt vật liệu</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Gợi ý chai nhựa nào phù hợp cho đựng nước uống?">
                                <i class="fa fa-tint"></i>
                                <span>Chai đựng nước</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Loại nhựa nào tốt nhất cho đựng hóa chất?">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span>Đựng hóa chất</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="suggestion-card" data-question="Kể tôi nghe về sản phẩm bình thể thao của bạn">
                                <i class="fa fa-futbol-o"></i>
                                <span>Bình thể thao</span>
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
<style>
    .chat-section {
        background: #f8f9fa;
        padding: 50px 0;
    }

    .chat-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .api-status {
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
        border: none;
        font-size: 14px;
    }

    .suggestions-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .suggestion-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
    }

    .suggestion-card:hover {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .suggestion-card i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
        opacity: 0.8;
    }

    .suggestion-card:hover i {
        opacity: 1;
    }

    .chats-container {
        height: 450px;
        overflow-y: auto;
        padding: 25px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    .chats-container::-webkit-scrollbar {
        width: 6px;
    }

    .chats-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 3px;
    }

    .chats-container::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    .message {
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* USER MESSAGE STYLES */
    .user-message {
        justify-content: flex-end;
    }

    .user-message .message-text {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 12px 18px;
        border-radius: 18px 18px 5px 18px;
        max-width: 75%;
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
        border: 1px solid #0056b3;
        font-weight: 500;
        line-height: 1.4;
    }

    /* AI MESSAGE STYLES */
    .bot-message {
        justify-content: flex-start;
    }

    .bot-message .message-text {
        background: white;
        padding: 12px 18px;
        border-radius: 18px 18px 18px 5px;
        border: 1px solid #e9ecef;
        max-width: 75%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        line-height: 1.5;
        color: #2d3748;
        margin-left: 10px;
    }

    .bot-message .message-text strong {
        color: #2d3748;
        font-weight: 700;
    }

    .avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-right: 12px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .user-message .avatar {
        display: none;
    }

    .bot-message .avatar {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: white;
    }

    .prompt-container {
        padding: 25px;
        border-top: 1px solid #e9ecef;
        background: white;
        position: relative;
    }

    .prompt-container::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 25px;
        right: 25px;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
    }

    .prompt-form {
        margin-bottom: 10px;
    }

    .input-group {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .prompt-input {
        border: none;
        padding: 15px 20px;
        font-size: 14px;
        background: white;
    }

    .prompt-input:focus {
        outline: none;
        box-shadow: none;
        background: white;
    }

    .prompt-input::placeholder {
        color: #a0aec0;
        font-weight: 400;
    }

    /* Nút send/stop */
    .send-btn,
    .stop-btn {
        border: none;
        padding: 15px 25px;
        border-radius: 0 25px 25px 0;
        transition: all 0.3s ease;
        min-width: 60px;
    }

    .send-btn {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .send-btn:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        transform: scale(1.05);
    }

    .send-btn:disabled {
        background: #6c757d;
        transform: none;
    }

    .stop-btn {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .stop-btn:hover {
        background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
        transform: scale(1.05);
    }

    .disclaimer-text {
        font-size: 11px;
        color: #a0aec0;
        text-align: center;
        margin: 0;
        font-style: italic;
    }

    .loading {
        opacity: 0.7;
    }

    .loading .message-text::after {
        content: '...';
        animation: dots 1.5s infinite;
    }

    @keyframes dots {

        0%,
        20% {
            content: '.';
        }

        40% {
            content: '..';
        }

        60%,
        100% {
            content: '...';
        }
    }

    /* Welcome message không có timestamp */
    .welcome-message .message-text+small {
        display: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chats-container {
            height: 350px;
            padding: 15px;
        }

        .user-message .message-text,
        .bot-message .message-text {
            max-width: 85%;
        }

        .suggestion-card {
            padding: 12px;
        }

        .suggestion-card i {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatsContainer = document.getElementById("chatsContainer");
        const promptForm = document.getElementById("promptForm");
        const promptInput = document.getElementById("promptInput");
        const sendButton = document.getElementById("sendButton");
        const stopButton = document.getElementById("stopButton");

        let isGenerating = false;
        let typingInterval = null;
        let currentTypingContent = "";
        let currentMessageElement = null;
        let abortController = null;
        let isStopped = false; // Flag để kiểm tra đã stop chưa

        // Create message element
        const createMessage = (content, isUser = false, showTimestamp = true) => {
            const messageDiv = document.createElement("div");
            messageDiv.className = `message ${isUser ? "user-message" : "bot-message"}`;

            const timestamp = showTimestamp ? new Date().toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            }) : '';

            if (isUser) {
                messageDiv.innerHTML = `
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <p class="message-text">${escapeHtml(content)}</p>
                        ${showTimestamp ? `<small style="font-size: 10px; color: #a0aec0; margin-top: 5px;">${timestamp}</small>` : ''}
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="avatar">AI</div>
                    <div style="flex: 1;">
                        <div class="message-text"></div>
                        ${showTimestamp ? `<small style="font-size: 10px; color: #a0aec0; margin-top: 5px; display: block;">${timestamp}</small>` : ''}
                    </div>
                `;
            }

            return messageDiv;
        };

        const escapeHtml = (text) => {
            const div = document.createElement("div");
            div.textContent = text;
            return div.innerHTML;
        };

        const scrollToBottom = () => {
            chatsContainer.scrollTop = chatsContainer.scrollHeight;
        };

        // Hàm stop - chỉ cancel request tương lai
        const stopGenerating = () => {
            // Hủy request API (chỉ cancel request chưa hoàn thành)
            if (abortController) {
                abortController.abort();
                abortController = null;
            }

            // Đánh dấu đã stop
            isStopped = true;

            // Reset UI
            sendButton.style.display = 'block';
            stopButton.style.display = 'none';
            isGenerating = false;
            sendButton.disabled = false;

            // KHÔNG xóa message hiện tại, giữ nguyên những gì đã generate
            console.log("Đã dừng generate - giữ nguyên response hiện tại");
        };

        // Hàm typeMessage - sử dụng requestAnimationFrame thay vì setInterval
        const typeMessage = (content, element, messageElement) => {
            if (typingInterval) cancelAnimationFrame(typingInterval);

            currentTypingContent = content;
            currentMessageElement = messageElement;
            isStopped = false;

            let index = 0;
            element.innerHTML = "";
            let lastTime = 0;
            const typingSpeed = 20; // milliseconds per character

            function typeCharacter(timestamp) {
                if (isStopped) {
                    cancelAnimationFrame(typingInterval);
                    typingInterval = null;
                    return;
                }

                if (index < content.length) {
                    // Đảm bảo tốc độ typing ổn định
                    if (timestamp - lastTime > typingSpeed) {
                        const partialContent = content.substring(0, index + 1);
                        element.innerHTML = partialContent;
                        index++;
                        scrollToBottom();
                        lastTime = timestamp;
                    }
                    typingInterval = requestAnimationFrame(typeCharacter);
                } else {
                    // Hoàn thành
                    typingInterval = null;
                    sendButton.style.display = 'block';
                    stopButton.style.display = 'none';
                    isGenerating = false;
                    sendButton.disabled = false;
                }
            }

            // Bắt đầu typing
            typingInterval = requestAnimationFrame(typeCharacter);
        };

        // Handle form submission
        promptForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const userMessage = promptInput.value.trim();
            if (!userMessage || isGenerating) return;

            promptInput.value = "";
            isGenerating = true;
            sendButton.disabled = true;
            isStopped = false; // Reset flag

            // Add user message
            const userMessageElement = createMessage(userMessage, true);
            chatsContainer.appendChild(userMessageElement);
            scrollToBottom();

            // Show loading
            const loadingMessage = createMessage("Đang suy nghĩ...", false);
            loadingMessage.classList.add("loading");
            chatsContainer.appendChild(loadingMessage);
            scrollToBottom();

            // Hiển thị nút stop
            sendButton.style.display = 'none';
            stopButton.style.display = 'block';

            try {
                // Tạo AbortController để có thể cancel request
                abortController = new AbortController();

                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: userMessage
                    }),
                    signal: abortController.signal
                });

                // Kiểm tra nếu đã stop thì không xử lý response
                if (isStopped) {
                    loadingMessage.remove();
                    return;
                }

                const data = await response.json();
                loadingMessage.remove();

                if (data.response && !isStopped) {
                    const aiMessageElement = createMessage("", false);
                    chatsContainer.appendChild(aiMessageElement);
                    const messageText = aiMessageElement.querySelector(".message-text");
                    typeMessage(data.response, messageText, aiMessageElement);
                } else if (data.error && !isStopped) {
                    throw new Error(data.error);
                } else if (!isStopped) {
                    throw new Error('Không có dữ liệu phản hồi');
                }

            } catch (error) {
                // Chỉ xử lý lỗi nếu không phải do cancel và chưa stop
                if (error.name !== 'AbortError' && !isStopped) {
                    console.error("Chat error:", error);
                    loadingMessage.remove();
                    const errorMessage = createMessage(
                        "❌ Lỗi: " + error.message,
                        false
                    );
                    chatsContainer.appendChild(errorMessage);
                } else if (error.name === 'AbortError') {
                    loadingMessage.remove();
                    console.log("Request đã bị cancel");
                }
            } finally {
                abortController = null;
                if (!isStopped) {
                    isGenerating = false;
                    sendButton.disabled = false;
                }
                promptInput.focus();
            }
        });

        // Quick suggestions
        document.querySelectorAll('.suggestion-card').forEach(card => {
            card.addEventListener('click', () => {
                const question = card.getAttribute('data-question');
                promptInput.value = question;
                promptForm.dispatchEvent(new Event('submit'));
            });
        });

        // Enter key to send
        promptInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                promptForm.dispatchEvent(new Event('submit'));
            }
        });

        // Stop button event
        stopButton.addEventListener('click', stopGenerating);

        // KHÔNG stop khi chuyển tab - tiếp tục generate
        // Comment hoặc xóa phần này hoàn toàn

        // Welcome message
        const welcomeMessage = createMessage(
            "Xin chào! 👋 Tôi là trợ lý AI của Plastic Store. Tôi có thể giúp bạn với:<br><br>" +
            "• <strong>Thông tin sản phẩm</strong> nhựa<br>" +
            "• <strong>So sánh vật liệu</strong> PET, PP, PC<br>" +
            "• <strong>Tư vấn lựa chọn</strong> sản phẩm phù hợp<br>" +
            "• <strong>Giải đáp thắc mắc</strong> về đặc tính<br><br>" +
            "Hãy hỏi tôi bất cứ điều gì về sản phẩm nhựa! 🛍️",
            false,
            false
        );
        welcomeMessage.classList.add('welcome-message');
        const messageText = welcomeMessage.querySelector(".message-text");
        messageText.innerHTML = welcomeMessage.querySelector(".message-text").textContent;
        chatsContainer.appendChild(welcomeMessage);
        scrollToBottom();
    });
</script>
@endsection