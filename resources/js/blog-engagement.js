/**
 * Blog Engagement JavaScript
 * Handles likes, comments, views, and reading duration tracking
 */

class BlogEngagement {
    constructor(blogId) {
        this.blogId = blogId;
        this.startTime = Date.now();
        this.isLiked = false;

        // Get CSRF token with validation
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        this.csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : null;

        if (!this.csrfToken) {
            console.error(
                "❌ CSRF token not found! Like functionality will not work."
            );
            console.log(
                "🔍 Available meta tags:",
                Array.from(document.querySelectorAll("meta")).map(
                    (m) => m.outerHTML
                )
            );
        } else {
            console.log(
                "✅ CSRF token loaded:",
                this.csrfToken.substring(0, 10) + "..."
            );
        }

        this.init();
    }

    init() {
        console.log("🚀 BlogEngagement initialized for blog ID:", this.blogId);
        this.setupEventListeners();

        // Record view with retry mechanism
        this.recordViewWithRetry();

        this.startDurationTracking();
        this.loadComments();
        this.loadStats();
    }

    setupEventListeners() {
        console.log("🔧 Setting up event listeners...");

        // Like button - Updated to match HTML id="like-btn"
        const likeButton = document.getElementById("like-btn");
        console.log("🔘 Like button found:", !!likeButton);
        console.log("🔘 Like button element:", likeButton);

        if (likeButton) {
            console.log("✅ Attaching click event to like button");
            likeButton.addEventListener("click", (e) => {
                e.preventDefault();
                console.log("🖱️ Like button clicked!");
                this.toggleLike();
            });

            // Test if button is clickable
            console.log("🔘 Button properties:");
            console.log("  - disabled:", likeButton.disabled);
            console.log(
                "  - display:",
                window.getComputedStyle(likeButton).display
            );
            console.log(
                "  - visibility:",
                window.getComputedStyle(likeButton).visibility
            );
        } else {
            console.error(
                "❌ Like button not found! Expected element with id='like-btn'"
            );
            console.log(
                "🔍 Available buttons:",
                Array.from(document.querySelectorAll("button")).map((b) => ({
                    id: b.id,
                    class: b.className,
                }))
            );
        }

        // Comment form
        const commentForm = document.getElementById("comment-form");
        if (commentForm) {
            commentForm.addEventListener("submit", (e) =>
                this.submitComment(e)
            );
        }

        // Reply buttons
        document.addEventListener("click", (e) => {
            if (e.target.classList.contains("reply-button")) {
                this.showReplyForm(e.target.dataset.commentId);
            }
        });

        // Page visibility change (track reading duration)
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                this.updateDuration();
            }
        });

        // Before page unload
        window.addEventListener("beforeunload", () => {
            this.updateDuration();
        });
    }

    async toggleLike() {
        console.log("🔄 Toggling like for blog:", this.blogId);
        console.log(
            "🔑 CSRF Token:",
            this.csrfToken ? this.csrfToken.substring(0, 10) + "..." : "MISSING"
        );

        // Check CSRF token
        if (!this.csrfToken) {
            console.error("❌ No CSRF token available");
            this.showToast("Session error. Please refresh the page.", "error");
            return;
        }

        try {
            const requestUrl = `/api/blog/${this.blogId}/like`;
            console.log("📡 Making request to:", requestUrl);

            const response = await fetch(requestUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                },
            });

            console.log("📡 Response status:", response.status);
            console.log("📡 Response ok:", response.ok);
            console.log("📡 Response URL:", response.url);

            if (!response.ok) {
                const errorText = await response.text();
                console.error("❌ HTTP Error:", response.status, errorText);
                console.error("❌ Request URL was:", requestUrl);
                console.error("❌ Blog ID was:", this.blogId);

                if (response.status === 419) {
                    this.showToast(
                        "Session expired. Please refresh the page.",
                        "error"
                    );
                } else if (response.status === 404) {
                    this.showToast("Article not found.", "error");
                } else if (response.status === 500) {
                    this.showToast("Server error. Please try again.", "error");
                } else {
                    this.showToast(
                        "Network error. Please check your connection.",
                        "error"
                    );
                }
                return;
            }

            const data = await response.json();
            console.log("📄 Response data:", data);

            if (data.success) {
                this.updateLikeButton(data.is_liked, data.likes_count);
                this.showToast(
                    data.action === "liked"
                        ? "Artikel disukai!"
                        : "Like dibatalkan"
                );
                console.log("✅ Like toggle successful");
            } else {
                console.error("❌ Server returned success=false:", data);
                this.showToast("Gagal memproses like", "error");
            }
        } catch (error) {
            console.error("❌ Error toggling like:", error);

            // More specific error messages
            if (error.name === "TypeError" && error.message.includes("fetch")) {
                this.showToast(
                    "Koneksi bermasalah. Periksa internet Anda.",
                    "error"
                );
            } else if (error.message.includes("JSON")) {
                this.showToast(
                    "Server response error. Please try again.",
                    "error"
                );
            } else {
                this.showToast("Terjadi kesalahan tidak terduga", "error");
            }
        }
    }

    async recordView() {
        console.log("📊 Recording view for blog:", this.blogId);
        try {
            const response = await fetch(`/api/blog/${this.blogId}/view`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });
            const result = await response.json();
            console.log("✅ View recorded successfully:", result);

            // Show visual feedback
            this.showViewRecordedFeedback(result.views_count);
        } catch (error) {
            console.error("❌ Error recording view:", error);
        }
    }

    async recordViewWithRetry(maxRetries = 3) {
        console.log("🔄 Recording view with retry mechanism...");

        for (let attempt = 1; attempt <= maxRetries; attempt++) {
            try {
                const response = await fetch(`/api/blog/${this.blogId}/view`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": this.csrfToken,
                    },
                });

                if (!response.ok) {
                    throw new Error(
                        `HTTP ${response.status}: ${response.statusText}`
                    );
                }

                const result = await response.json();
                console.log(
                    `✅ View recorded successfully on attempt ${attempt}:`,
                    result
                );

                // Show success feedback
                this.showViewRecordedFeedback(result.views_count);
                return;
            } catch (error) {
                console.error(`❌ Attempt ${attempt} failed:`, error.message);

                if (attempt === maxRetries) {
                    console.error("🚫 All retry attempts failed");
                    // Fallback: try alternative method
                    this.fallbackViewRecording();
                } else {
                    // Wait before retry
                    await new Promise((resolve) =>
                        setTimeout(resolve, 1000 * attempt)
                    );
                }
            }
        }
    }

    fallbackViewRecording() {
        console.log("🆘 Using fallback view recording method...");

        // Try using image pixel tracking as fallback
        const img = new Image();
        img.onload = () => {
            console.log("✅ Fallback view recorded via image tracking");
        };
        img.onerror = () => {
            console.error("❌ Fallback method also failed");
        };
        img.src = `/api/blog/${this.blogId}/view-pixel?t=${Date.now()}`;
    }

    showViewRecordedFeedback(viewsCount) {
        // Create small notification
        const notification = document.createElement("div");
        notification.className =
            "fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg text-sm z-50 opacity-0 transition-opacity duration-300";
        notification.innerHTML = `📊 View recorded! Total: ${viewsCount}`;

        document.body.appendChild(notification);

        // Show notification
        setTimeout(() => (notification.style.opacity = "1"), 100);

        // Hide and remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    async submitComment(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(`/api/blog/${this.blogId}/comment`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                this.addCommentToDOM(data.comment);
                this.updateCommentsCount(data.comments_count);
                form.reset();
                this.showToast(data.message);
            } else {
                this.showToast("Gagal menambahkan komentar", "error");
            }
        } catch (error) {
            console.error("Error submitting comment:", error);
            this.showToast("Terjadi kesalahan", "error");
        }
    }

    async loadComments() {
        try {
            const response = await fetch(`/api/blog/${this.blogId}/comments`);
            const data = await response.json();

            if (data.success) {
                this.renderComments(data.comments);
            }
        } catch (error) {
            console.error("Error loading comments:", error);
        }
    }

    async loadStats() {
        try {
            const response = await fetch(`/api/blog/${this.blogId}/stats`);
            const data = await response.json();

            if (data.success) {
                this.updateStats(data.stats);
            }
        } catch (error) {
            console.error("Error loading stats:", error);
        }
    }

    async updateDuration() {
        const duration = Math.floor((Date.now() - this.startTime) / 1000);

        if (duration > 5) {
            // Only track if read for more than 5 seconds
            try {
                await fetch(`/api/blog/${this.blogId}/duration`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": this.csrfToken,
                    },
                    body: JSON.stringify({ duration }),
                });
            } catch (error) {
                console.error("Error updating duration:", error);
            }
        }
    }

    startDurationTracking() {
        // Update duration every 30 seconds
        setInterval(() => {
            if (!document.hidden) {
                this.updateDuration();
            }
        }, 30000);
    }

    updateLikeButton(isLiked, likesCount) {
        const button = document.getElementById("like-btn");
        const icon = button?.querySelector(".like-icon");
        const buttonCount = document.getElementById("like-count");
        const statsCount = document.getElementById("likes-count");
        const text = button?.querySelector(".like-text");

        if (button) {
            if (isLiked) {
                button.classList.add("liked");
                button.classList.remove("border-red-500", "text-red-500");
                button.classList.add("bg-red-500", "text-white");
                if (text) text.textContent = "Liked";
            } else {
                button.classList.remove("liked", "bg-red-500", "text-white");
                button.classList.add("border-red-500", "text-red-500");
                if (text) text.textContent = "Like";
            }
        }

        // Update both button count and stats count with animation
        if (buttonCount) {
            const currentCount = parseInt(buttonCount.dataset.count || "0");
            const isIncrement = likesCount > currentCount;

            // Use the global animation function from detail.blade.php
            if (typeof window.animateLikeCounter === "function") {
                window.animateLikeCounter(likesCount, isIncrement);
            } else {
                // Fallback to simple update
                const formattedCount = this.formatNumber(likesCount);
                buttonCount.textContent = formattedCount;
                buttonCount.dataset.count = likesCount;
            }
        }

        if (statsCount) {
            statsCount.textContent = this.formatNumber(likesCount);
        }

        this.isLiked = isLiked;
    }

    updateCommentsCount(count) {
        const element = document.getElementById("comments-count");
        if (element) {
            element.textContent = this.formatNumber(count);
        }
    }

    updateStats(stats) {
        const viewsElement = document.getElementById("views-count");
        const likesElement = document.getElementById("likes-count");
        const commentsElement = document.getElementById("comments-count");

        if (viewsElement)
            viewsElement.textContent = this.formatNumber(stats.views_count);
        if (likesElement)
            likesElement.textContent = this.formatNumber(stats.likes_count);
        if (commentsElement)
            commentsElement.textContent = this.formatNumber(
                stats.comments_count
            );
    }

    addCommentToDOM(comment) {
        const commentsContainer = document.getElementById("comments-container");
        const commentHTML = this.generateCommentHTML(comment);

        if (comment.parent_id) {
            // This is a reply
            const parentComment = document.querySelector(
                `[data-comment-id="${comment.parent_id}"]`
            );
            const repliesContainer =
                parentComment.querySelector(".replies-container");
            repliesContainer.insertAdjacentHTML("beforeend", commentHTML);
        } else {
            // This is a top-level comment
            commentsContainer.insertAdjacentHTML("afterbegin", commentHTML);
        }
    }

    renderComments(comments) {
        const container = document.getElementById("comments-container");
        if (!container) return;

        container.innerHTML = comments
            .map((comment) => this.generateCommentHTML(comment, true))
            .join("");
    }

    generateCommentHTML(comment, includeReplies = false) {
        let html = `
            <div class="comment mb-6 p-4 bg-gray-50 rounded-lg" data-comment-id="${
                comment.id
            }">
                <div class="flex items-start space-x-3">
                    <img src="${comment.avatar_url}" alt="${comment.name}" 
                         class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h4 class="font-semibold text-gray-900">${
                                comment.name
                            }</h4>
                            <span class="text-sm text-gray-500">${
                                comment.formatted_date
                            }</span>
                        </div>
                        <p class="text-gray-700 mb-3">${comment.comment}</p>
                        <button class="reply-button text-sm text-blue-600 hover:text-blue-800" 
                                data-comment-id="${comment.id}">
                            Balas
                        </button>
                    </div>
                </div>
                <div class="replies-container ml-13 mt-4">
                    ${
                        includeReplies && comment.replies
                            ? comment.replies
                                  .map((reply) =>
                                      this.generateCommentHTML(reply, false)
                                  )
                                  .join("")
                            : ""
                    }
                </div>
            </div>
        `;

        return html;
    }

    showReplyForm(commentId) {
        // Remove any existing reply forms
        document
            .querySelectorAll(".reply-form")
            .forEach((form) => form.remove());

        const comment = document.querySelector(
            `[data-comment-id="${commentId}"]`
        );
        const repliesContainer = comment.querySelector(".replies-container");

        const replyFormHTML = `
            <form class="reply-form mt-4 p-4 bg-white rounded border">
                <input type="hidden" name="parent_id" value="${commentId}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <input type="text" name="name" placeholder="Nama Anda" required
                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="email" name="email" placeholder="Email Anda" required
                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <textarea name="comment" placeholder="Tulis balasan Anda..." required rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"></textarea>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Kirim Balasan
                    </button>
                    <button type="button" class="cancel-reply px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                </div>
            </form>
        `;

        repliesContainer.insertAdjacentHTML("beforeend", replyFormHTML);

        // Add event listeners for the new form
        const replyForm = repliesContainer.querySelector(".reply-form");
        replyForm.addEventListener("submit", (e) => this.submitComment(e));
        replyForm
            .querySelector(".cancel-reply")
            .addEventListener("click", () => replyForm.remove());
    }

    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + "M";
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + "K";
        }
        return num.toString();
    }

    showToast(message, type = "success") {
        // Create toast notification
        const toast = document.createElement("div");
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 transition-opacity duration-300 ${
            type === "success" ? "bg-green-500" : "bg-red-500"
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    console.log("🎯 DEBUG: blog-engagement.js loaded and DOM ready");
    console.log("🔍 Checking for blog ID element...");

    const blogElement = document.querySelector("[data-blog-id]");
    console.log("🔘 Blog element found:", !!blogElement);
    console.log("🔘 Blog element:", blogElement);

    const blogId = blogElement?.dataset.blogId;
    console.log("🆔 Found blog ID:", blogId);

    if (blogId) {
        console.log("✅ Initializing BlogEngagement for blog:", blogId);
        console.log("⏰ Initializing in 100ms to ensure DOM is fully ready...");

        // Small delay to ensure all DOM elements are ready
        setTimeout(() => {
            console.log("🚀 Creating BlogEngagement instance now...");
            try {
                new BlogEngagement(blogId);
                console.log("✅ BlogEngagement instance created successfully");
            } catch (error) {
                console.error("❌ Error creating BlogEngagement:", error);
            }
        }, 100);
    } else {
        console.log("❌ No blog ID found, BlogEngagement not initialized");
        console.log(
            "🔍 Available elements with data-blog-id:",
            Array.from(document.querySelectorAll("[data-blog-id]")).map(
                (el) => ({
                    tag: el.tagName,
                    id: el.id,
                    class: el.className,
                    blogId: el.dataset.blogId,
                })
            )
        );
    }
});
