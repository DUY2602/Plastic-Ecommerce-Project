document.addEventListener("DOMContentLoaded", function () {
    console.log("Dashboard JS loaded");

    // Count up animation - FIXED VERSION
    function initCountUpAnimation() {
        const counters = document.querySelectorAll(".count-up");

        if (!counters || counters.length === 0) {
            console.warn("No .count-up elements found");
            return;
        }

        console.log(`Found ${counters.length} count-up elements`);

        counters.forEach((counter, index) => {
            // Kiểm tra counter có tồn tại không
            if (!counter) {
                console.warn(`Counter ${index} is null`);
                return;
            }

            const targetText = counter.getAttribute("data-count");
            if (!targetText) {
                console.warn(`Counter ${index} has no data-count attribute`);
                return;
            }

            const target = parseInt(targetText);
            if (isNaN(target)) {
                console.warn(
                    `Counter ${index} has invalid data-count: ${targetText}`
                );
                return;
            }

            console.log(`Initializing counter ${index}: target = ${target}`);

            // Đặt giá trị ban đầu là 0
            counter.textContent = "0";

            // Kiểm tra IntersectionObserver có hỗ trợ không
            if ("IntersectionObserver" in window) {
                const observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                startCountAnimation(entry.target, target);
                                observer.unobserve(entry.target);
                            }
                        });
                    },
                    {
                        threshold: 0.5, // Khi 50% phần tử hiển thị
                    }
                );

                observer.observe(counter);
            } else {
                // Fallback: chạy animation ngay lập tức
                startCountAnimation(counter, target);
            }
        });
    }

    function startCountAnimation(element, target) {
        if (!element) return;

        const duration = 2000;
        const stepTime = 16; // ~60fps
        const totalSteps = duration / stepTime;
        const increment = target / totalSteps;

        let current = 0;
        let stepCount = 0;

        const timer = setInterval(() => {
            stepCount++;
            current += increment;

            if (stepCount >= totalSteps || current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, stepTime);
    }

    // Floating particles - FIXED VERSION
    function createParticles() {
        // Kiểm tra xem đã có particles-container chưa
        if (document.querySelector(".particles-container")) {
            console.log("Particles container already exists");
            return;
        }

        const container = document.createElement("div");
        container.className = "particles-container";

        // Đảm bảo container được thêm vào đúng vị trí
        document.body.insertBefore(container, document.body.firstChild);

        for (let i = 0; i < 15; i++) {
            const particle = document.createElement("div");
            particle.className = "particle";

            // Random properties với giới hạn an toàn
            const size = Math.random() * 40 + 10; // 10-50px
            const posX = Math.random() * 95; // 0-95%
            const posY = Math.random() * 95; // 0-95%
            const delay = Math.random() * 5;
            const duration = Math.random() * 3 + 3;

            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;
            particle.style.animationDelay = `${delay}s`;
            particle.style.animationDuration = `${duration}s`;
            particle.style.opacity = "0.7";

            container.appendChild(particle);
        }

        console.log("Particles created successfully");
    }

    // Khởi tạo mọi thứ
    function initializeDashboard() {
        console.log("Initializing dashboard...");

        // 1. Chạy count-up animation
        initCountUpAnimation();

        // 2. Tạo particles (chỉ nếu có CSS hỗ trợ)
        if (document.querySelector(".particles-container")) {
            createParticles();
        } else {
            console.log(
                "No particles container in DOM, skipping particles creation"
            );
        }

        // 3. Thêm hover effect cho cards
        addCardHoverEffects();

        // 4. Thêm hover effect cho table rows
        addTableRowEffects();
    }

    function addCardHoverEffects() {
        const cards = document.querySelectorAll(".card-glass, .small-box");

        cards.forEach((card) => {
            if (!card) return;

            card.addEventListener("mouseenter", function () {
                this.style.transform = "translateY(-8px) scale(1.02)";
                this.style.boxShadow = "0 15px 40px 0 rgba(31, 38, 135, 0.5)";
                this.style.border = "1px solid rgba(255, 255, 255, 0.4)";
            });

            card.addEventListener("mouseleave", function () {
                this.style.transform = "";
                this.style.boxShadow = "";
                this.style.border = "";
            });
        });
    }

    function addTableRowEffects() {
        const tableRows = document.querySelectorAll(".table-row-glass");

        tableRows.forEach((row) => {
            if (!row) return;

            row.addEventListener("mouseenter", function () {
                this.style.backgroundColor = "rgba(255, 255, 255, 0.15)";
                this.style.transform = "translateX(5px)";
            });

            row.addEventListener("mouseleave", function () {
                this.style.backgroundColor = "";
                this.style.transform = "";
            });
        });
    }

    // Chạy khởi tạo
    initializeDashboard();

    // Debug: log tất cả .count-up elements
    setTimeout(() => {
        const countElements = document.querySelectorAll(".count-up");
        console.log(`Total .count-up elements in DOM: ${countElements.length}`);
        countElements.forEach((el, idx) => {
            console.log(`Element ${idx}:`, {
                text: el.textContent,
                dataCount: el.getAttribute("data-count"),
                inViewport: el.getBoundingClientRect().top < window.innerHeight,
            });
        });
    }, 500);
});
