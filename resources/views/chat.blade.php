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
                                    <button type="submit" id="sendButton" class="btn btn-primary">
                                        <i class="fa fa-paper-plane"></i>
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
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .api-status {
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
    }

    .suggestions-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .suggestion-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .suggestion-card:hover {
        background: #007bff;
        color: white;
        transform: translateY(-2px);
    }

    .suggestion-card i {
        display: block;
        font-size: 20px;
        margin-bottom: 5px;
    }

    .chats-container {
        height: 400px;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }

    .user-message {
        justify-content: flex-end;
    }

    .user-message .message-text {
        background: #007bff;
        color: white;
        padding: 10px 15px;
        border-radius: 18px 18px 0 18px;
        max-width: 70%;
    }

    .bot-message .message-text {
        background: white;
        padding: 10px 15px;
        border-radius: 18px 18px 18px 0;
        border: 1px solid #e9ecef;
        max-width: 70%;
    }

    .avatar {
        width: 30px;
        height: 30px;
        background: #28a745;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .prompt-container {
        padding: 20px;
        border-top: 1px solid #e9ecef;
        background: white;
    }

    .disclaimer-text {
        font-size: 12px;
        color: #6c757d;
        text-align: center;
        margin: 0;
    }

    .loading {
        opacity: 0.7;
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

        let isGenerating = false;
        let typingInterval = null;
        let currentTypingContent = ""; // Lưu toàn bộ content đang type
        let currentMessageElement = null; // Element message đang được type
        let isStopped = false; // Flag để stop typing

        // Create message element
        const createMessage = (content, isUser = false) => {
            const messageDiv = document.createElement("div");
            messageDiv.className = `message ${isUser ? "user-message" : "bot-message"}`;

            if (isUser) {
                messageDiv.innerHTML = `<p class="message-text">${escapeHtml(content)}</p>`;
            } else {
                messageDiv.innerHTML = `
                    <div class="avatar">AI</div>
                    <div class="message-text"></div>
                    ${!isUser ? '<button class="stop-btn" style="display:none;"><i class="fa fa-stop"></i></button>' : ''}
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

        // Hàm stop typing
        const stopTyping = () => {
            if (typingInterval) {
                clearInterval(typingInterval);
                typingInterval = null;
            }
            if (currentMessageElement) {
                const stopBtn = currentMessageElement.querySelector('.stop-btn');
                if (stopBtn) stopBtn.style.display = 'none';

                // Hiển thị toàn bộ content nếu bị dừng giữa chừng
                const messageText = currentMessageElement.querySelector('.message-text');
                messageText.innerHTML = currentTypingContent;
            }
            isStopped = true;
            isGenerating = false;
            sendButton.disabled = false;
        };

        // Hàm typeMessage với giữ nguyên HTML
        const typeMessage = (content, element, messageElement) => {
            if (typingInterval) clearInterval(typingInterval);

            currentTypingContent = content;
            currentMessageElement = messageElement;
            isStopped = false;

            // Hiển thị nút stop
            const stopBtn = messageElement.querySelector('.stop-btn');
            if (stopBtn) {
                stopBtn.style.display = 'inline-block';
                stopBtn.onclick = stopTyping;
            }

            let index = 0;
            element.innerHTML = "";

            typingInterval = setInterval(() => {
                if (isStopped) {
                    clearInterval(typingInterval);
                    return;
                }

                if (index < content.length) {
                    // Lấy phần content từ đầu đến index hiện tại
                    const partialContent = content.substring(0, index + 1);
                    element.innerHTML = partialContent;
                    index++;
                    scrollToBottom();
                } else {
                    clearInterval(typingInterval);
                    typingInterval = null;
                    // Ẩn nút stop khi hoàn thành
                    if (stopBtn) stopBtn.style.display = 'none';
                    isGenerating = false;
                    sendButton.disabled = false;
                }
            }, 20);
        };

        // Handle form submission
        promptForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const userMessage = promptInput.value.trim();
            if (!userMessage || isGenerating) return;

            promptInput.value = "";
            isGenerating = true;
            sendButton.disabled = true;
            isStopped = false;

            // Add user message
            const userMessageElement = createMessage(userMessage, true);
            chatsContainer.appendChild(userMessageElement);
            scrollToBottom();

            // Show loading
            const loadingMessage = createMessage("Đang suy nghĩ...", false);
            loadingMessage.classList.add("loading");
            chatsContainer.appendChild(loadingMessage);
            scrollToBottom();

            try {
                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: userMessage
                    })
                });

                const data = await response.json();
                loadingMessage.remove();

                if (data.response && !isStopped) {
                    const aiMessageElement = createMessage("", false);
                    chatsContainer.appendChild(aiMessageElement);
                    const messageText = aiMessageElement.querySelector(".message-text");

                    // Hiển thị response với typing effect
                    typeMessage(data.response, messageText, aiMessageElement);

                } else if (data.error && !isStopped) {
                    throw new Error(data.error);
                } else if (!isStopped) {
                    throw new Error('Không có dữ liệu phản hồi');
                }

            } catch (error) {
                if (!isStopped) {
                    console.error("Chat error:", error);
                    loadingMessage.remove();
                    const errorMessage = createMessage(
                        "❌ Lỗi: " + error.message,
                        false
                    );
                    chatsContainer.appendChild(errorMessage);
                }
            } finally {
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

        // Stop typing khi chuyển tab
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && isGenerating) {
                stopTyping();
            }
        });

        // CSS cho nút stop
        const style = document.createElement('style');
        style.textContent = `
            .stop-btn {
                background: #dc3545;
                color: white;
                border: none;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                margin-left: 10px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .stop-btn:hover {
                background: #c82333;
            }
            .bot-message {
                display: flex;
                align-items: flex-start;
            }
        `;
        document.head.appendChild(style);

        // Welcome message
        const welcomeMessage = createMessage(
            "Xin chào! 👋 Tôi là trợ lý AI của Plastic Store. Tôi có thể giúp bạn với:<br><br>" +
            "• <strong>Thông tin sản phẩm</strong> nhựa<br>" +
            "• <strong>So sánh vật liệu</strong> PET, PP, PC<br>" +
            "• <strong>Tư vấn lựa chọn</strong> sản phẩm phù hợp<br>" +
            "• <strong>Giải đáp thắc mắc</strong> về đặc tính<br><br>" +
            "Hãy hỏi tôi bất cứ điều gì về sản phẩm nhựa! 🛍️",
            false
        );
        // Hiển thị welcome message ngay lập tức (không type)
        const messageText = welcomeMessage.querySelector(".message-text");
        messageText.innerHTML = welcomeMessage.querySelector(".message-text").textContent;
        chatsContainer.appendChild(welcomeMessage);
        scrollToBottom();
    });
</script>
@endsection