// public/js/chat.js - FIXED VERSION (NO PHP SYNTAX)
document.addEventListener("DOMContentLoaded", () => {
    const chatsContainer = document.getElementById("chatsContainer");
    const promptInput = document.getElementById("promptInput");
    const promptForm = document.getElementById("promptForm");
    const sendButton = document.getElementById("sendButton");
    const stopButton = document.getElementById("stopButton");

    // Get CSRF token from meta tag
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    if (!csrfToken) {
        console.error("CSRF token not found!");
    }

    // Get route from data attribute (thêm trong HTML)
    const chatRoute =
        document
            .querySelector("[data-chat-route]")
            ?.getAttribute("data-chat-route") || "/chat/send";

    let isGenerating = false;
    let typingInterval = null;
    let currentTypingContent = "";
    let currentMessageElement = null;
    let isStopped = false;
    let abortController = null;

    // Hàm tạo message
    const createMessage = (content, isUser = false, showTimestamp = true) => {
        const messageDiv = document.createElement("div");
        messageDiv.className = `message ${
            isUser ? "user-message" : "bot-message"
        }`;

        const timestamp = showTimestamp
            ? new Date().toLocaleTimeString("en-US", {
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "";

        if (isUser) {
            messageDiv.innerHTML = `
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <p class="message-text">${escapeHtml(content)}</p>
                        ${
                            showTimestamp
                                ? `<small style="font-size: 10px; color: #a0aec0; margin-top: 5px;">${timestamp}</small>`
                                : ""
                        }
                    </div>
                `;
        } else {
            messageDiv.innerHTML = `
                    <div class="avatar">AI</div>
                    <div style="flex: 1;">
                        <div class="message-text"></div>
                        ${
                            showTimestamp
                                ? `<small style="font-size: 10px; color: #a0aec0; margin-top: 5px; display: block;">${timestamp}</small>`
                                : ""
                        }
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

    // Stop function
    const stopGenerating = () => {
        if (abortController) {
            abortController.abort();
            abortController = null;
        }

        isStopped = true;
        sendButton.style.display = "block";
        stopButton.style.display = "none";
        isGenerating = false;
        sendButton.disabled = false;

        if (typingInterval) {
            cancelAnimationFrame(typingInterval);
            typingInterval = null;
        }
    };

    // typeMessage function
    const typeMessage = (content, element, messageElement) => {
        if (typingInterval) cancelAnimationFrame(typingInterval);

        currentTypingContent = content;
        currentMessageElement = messageElement;
        isStopped = false;

        let index = 0;
        element.innerHTML = "";
        let lastTime = 0;
        const typingSpeed = 10;

        function typeCharacter(timestamp) {
            if (isStopped) {
                cancelAnimationFrame(typingInterval);
                typingInterval = null;
                return;
            }

            if (index < content.length) {
                if (timestamp - lastTime > typingSpeed) {
                    const partialContent = content.substring(0, index + 1);
                    element.innerHTML = partialContent;
                    index++;
                    scrollToBottom();
                    lastTime = timestamp;
                }
                typingInterval = requestAnimationFrame(typeCharacter);
            } else {
                typingInterval = null;
                sendButton.style.display = "block";
                stopButton.style.display = "none";
                isGenerating = false;
                sendButton.disabled = false;
            }
        }

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
        isStopped = false;

        // Add user message
        const userMessageElement = createMessage(userMessage, true);
        chatsContainer.appendChild(userMessageElement);
        scrollToBottom();

        // Show loading
        const loadingMessage = createMessage("Thinking...", false);
        loadingMessage.classList.add("loading");
        chatsContainer.appendChild(loadingMessage);
        scrollToBottom();

        // Show stop button
        sendButton.style.display = "none";
        stopButton.style.display = "block";

        try {
            abortController = new AbortController();

            const response = await fetch(chatRoute, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    message: userMessage,
                }),
                signal: abortController.signal,
            });

            if (isStopped) {
                loadingMessage.remove();
                return;
            }

            const data = await response.json();
            loadingMessage.remove();

            if (data.response && !isStopped) {
                const aiMessageElement = createMessage("", false);
                chatsContainer.appendChild(aiMessageElement);
                const messageText =
                    aiMessageElement.querySelector(".message-text");
                typeMessage(data.response, messageText, aiMessageElement);
            } else if (data.error && !isStopped) {
                throw new Error(data.error);
            } else if (!isStopped) {
                throw new Error("No response data");
            }
        } catch (error) {
            if (error.name !== "AbortError" && !isStopped) {
                console.error("Chat error:", error);
                loadingMessage.remove();
                const errorMessage = createMessage(
                    "❌ Error: " + error.message,
                    false
                );
                chatsContainer.appendChild(errorMessage);
            } else if (error.name === "AbortError") {
                loadingMessage.remove();
                console.log("Request cancelled");
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
    document.querySelectorAll(".suggestion-card").forEach((card) => {
        card.addEventListener("click", () => {
            const question = card.getAttribute("data-question");
            promptInput.value = question;
            promptForm.dispatchEvent(new Event("submit"));
        });
    });

    // Enter key to send
    promptInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            promptForm.dispatchEvent(new Event("submit"));
        }
    });

    // Stop button event
    stopButton.addEventListener("click", stopGenerating);

    // Welcome message
    const welcomeMessage = createMessage("", false, false);
    welcomeMessage.classList.add("welcome-message");
    const messageText = welcomeMessage.querySelector(".message-text");
    messageText.innerHTML =
        "Hello! 👋 I am the AI assistant of Plastic Store. I can help you with:<br><br>" +
        "• <strong>Product Information</strong> about plastics<br>" +
        "• <strong>Material Comparisons</strong> PET, PP, PC<br>" +
        "• <strong>Product Selection Advice</strong> for suitable products<br>" +
        "• <strong>Answering Questions</strong> about properties<br><br>" +
        "Ask me anything about plastic products! 🛍️";
    chatsContainer.appendChild(welcomeMessage);
    scrollToBottom();

    console.log("Chat JS loaded successfully");
});
