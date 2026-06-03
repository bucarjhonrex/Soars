<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const postContent = ref('');
const postImage = ref(null);
const posts = ref([]);

const handlePost = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('content', postContent.value);
    if (postImage.value) {
        formData.append('image', postImage.value);
    }

    try {
        await axios.post(route('posts.store'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        alert("Posted successfully!");
        postContent.value = '';
        postImage.value = null;

        fetchPosts();
    } catch (error) {
        console.error(error);
        alert("There was an error uploading the post.");
    }
};

const fetchPosts = async () => {
    try {
        const response = await axios.get(route('posts.fetch'));
        posts.value = response.data;
    } catch(error) {
        console.error('Error in the fetch', error);
    }
};

onMounted(() => {
    fetchPosts();
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="page-header-title">
                <i class="fas fa-home"></i>
                HOME
            </h2>
        </template>

        <div class="home-container">
            <!-- Notification Banner -->
            <div class="notification-banner">
                <i class="fas fa-info-circle"></i>
                <span>Welcome to the announcement board. Stay updated with the latest news from the Registrar Office.</span>
            </div>

            <!-- Post Form -->
            <!-- Only show this to admin -->
            <div v-if="$page.props.auth.user.role === 'admin'" class="post-form-card">
                <h6 class="form-title">
                    <i class="fas fa-bullhorn"></i>
                    Registrar Office
                </h6>
                <form @submit="handlePost" class="post-form">
                    <textarea
                        v-model="postContent"
                        placeholder="Write the announcement here..."
                        class="post-textarea"
                        rows="4"
                    ></textarea>

                    <div class="file-input-wrapper">
                        <input
                            type="file"
                            accept="image/*"
                            @change="e => postImage = e.target.files[0]"
                            class="file-input"
                            id="fileInput"
                        />
                        <label for="fileInput" class="file-label">
                            <i class="fas fa-paperclip"></i>
                            Choose File
                        </label>
                    </div>

                    <button type="submit" class="post-button">
                        <i class="fas fa-paper-plane"></i>
                        Post Announcement
                    </button>
                </form>
            </div>

            <!-- Post Feed -->
            <div class="post-feed">
                <div v-for="post in posts" :key="post.id" class="post-card">
                    <div class="post-header">
                        <div class="post-avatar"></div>
                        <div class="post-info">
                            <p class="post-author">{{ post.title }}</p>
                            <p class="post-time">
                                <i class="far fa-clock"></i>
                                {{ new Date(post.posted_at).toLocaleString() }}
                            </p>
                        </div>
                    </div>
                    <p class="post-content">{{ post.content }}</p>
                    <div class="post-media">
                        <img
                            v-if="post.image_url"
                            :src="post.image_url"
                            alt="Registrar Office Posted"
                            class="post-image"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* Header Styling */
.page-header-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-header-title i {
    color: #14b8a6;
    font-size: 22px;
}

/* Main Container */
.home-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Notification Banner */
.notification-banner {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.25);
    animation: slideDown 0.5s ease;
}

.notification-banner i {
    font-size: 20px;
    flex-shrink: 0;
}

.notification-banner span {
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Post Form Card */
.post-form-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 2px solid #f0fdfa;
    transition: all 0.3s ease;
}

.post-form-card:hover {
    box-shadow: 0 4px 20px rgba(20, 184, 166, 0.15);
    border-color: #ccfbf1;
}

.form-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f0fdfa;
}

.form-title i {
    color: #14b8a6;
    font-size: 20px;
}

/* Post Form */
.post-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.post-textarea {
    width: 100%;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px;
    font-size: 14px;
    font-family: inherit;
    resize: vertical;
    transition: all 0.3s ease;
    background-color: #fafafa;
}

.post-textarea:focus {
    outline: none;
    border-color: #14b8a6;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.post-textarea::placeholder {
    color: #9ca3af;
}

/* File Input */
.file-input-wrapper {
    position: relative;
}

.file-input {
    opacity: 0;
    position: absolute;
    z-index: -1;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background-color: #f0fdfa;
    color: #14b8a6;
    border: 2px solid #14b8a6;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-label:hover {
    background-color: #14b8a6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.file-label i {
    font-size: 16px;
}

/* Post Button */
.post-button {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    padding: 14px 24px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.post-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(20, 184, 166, 0.4);
}

.post-button:active {
    transform: translateY(0);
}

.post-button i {
    font-size: 16px;
}

/* Post Feed */
.post-feed {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Post Card */
.post-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease;
}

.post-card:hover {
    box-shadow: 0 8px 24px rgba(20, 184, 166, 0.12);
    border-color: #ccfbf1;
    transform: translateY(-4px);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Post Header */
.post-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
}

.post-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    border-radius: 50%;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);
    position: relative;
}

.post-avatar::after {
    content: '\f007';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 20px;
}

.post-info {
    flex: 1;
}

.post-author {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 4px 0;
}

.post-time {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.post-time i {
    color: #14b8a6;
}

/* Post Content */
.post-content {
    color: #374151;
    font-size: 15px;
    line-height: 1.6;
    margin: 0 0 16px 0;
    white-space: pre-wrap;
}

/* Post Media */
.post-media {
    margin-top: 16px;
}

.post-image {
    width: 100%;
    border-radius: 12px;
    display: block;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.post-image:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
    .home-container {
        padding: 16px 12px;
    }

    .post-form-card,
    .post-card {
        padding: 20px;
        border-radius: 12px;
    }

    .notification-banner {
        padding: 14px 16px;
        font-size: 13px;
    }

    .post-button {
        width: 100%;
    }
}

/* Loading State (Optional Enhancement) */
.post-card.loading {
    opacity: 0.6;
    pointer-events: none;
}
</style>
