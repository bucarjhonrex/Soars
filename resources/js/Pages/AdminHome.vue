<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
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
  <Head title="AdminHome" />

  <AdminAuthenticatedLayout>
    <template #header>
      <h2 class="header-title">HOME</h2>
    </template>

    <div class="container">

      <!-- Post Form -->
      <div class="post-form-card">
        <div class="form-header">
          <div class="teal-dot"></div>
          <h6 class="form-title">Registrar Office</h6>
        </div>

        <form @submit="handlePost" class="post-form">
          <textarea
            v-model="postContent"
            placeholder="Write the announcement here..."
            class="post-textarea"
            rows="4"
          ></textarea>

          <div class="file-upload-section">
            <label class="file-upload-label">
              <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="upload-text">Add Image</span>
              <input
                type="file"
                accept="image/*"
                @change="e => postImage = e.target.files[0]"
                class="file-input-hidden"
              />
            </label>

            <span v-if="postImage" class="file-name">
              ✓ {{ postImage.name }}
            </span>
          </div>

          <button type="submit" class="submit-button">
            Post Announcement
          </button>
        </form>
      </div>

      <!-- Post Feed -->
      <div class="posts-feed">
        <div
          v-for="post in posts"
          :key="post.id"
          class="post-card"
        >
          <div class="post-header">
            <div class="avatar">
              <svg class="avatar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div class="post-info">
              <p class="post-title">{{ post.title }}</p>
              <p class="post-date">
                {{ new Date(post.posted_at).toLocaleString() }}
              </p>
            </div>
          </div>

          <p class="post-content">{{ post.content }}</p>

          <div v-if="post.image_url" class="post-image-container">
            <img
              :src="post.image_url"
              alt="Registrar Office Posted"
              class="post-image"
            />
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="posts.length === 0" class="empty-state">
          <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <p class="empty-title">No announcements yet</p>
          <p class="empty-subtitle">Be the first to post an announcement</p>
        </div>
      </div>

    </div>
  </AdminAuthenticatedLayout>
</template>

<style scoped>
.header-title {
  font-size: 1.25rem;
  font-weight: 600;
  line-height: 1.75rem;
  color: #1f2937;
}

.container {
  max-width: 48rem;
  margin: 0 auto;
  padding: 1.5rem 0;
}

.post-form-card {
  background: white;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 1.5rem;
  border-left: 4px solid #14b8a6;
  margin-bottom: 1.5rem;
}

.form-header {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.teal-dot {
  width: 0.5rem;
  height: 0.5rem;
  background: #14b8a6;
  border-radius: 50%;
  margin-right: 0.5rem;
}

.form-title {
  font-weight: 600;
  color: #0f766e;
  font-size: 1.125rem;
  margin: 0;
}

.post-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.post-textarea {
  width: 100%;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  font-family: inherit;
  font-size: 1rem;
  resize: none;
  transition: all 0.2s;
}

.post-textarea:focus {
  outline: none;
  border-color: transparent;
  box-shadow: 0 0 0 2px #14b8a6;
}

.file-upload-section {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.file-upload-label {
  display: flex;
  align-items: center;
  padding: 0.5rem 1rem;
  background: #f9fafb;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.2s;
}

.file-upload-label:hover {
  background: #f0fdfa;
  border-color: #5eead4;
}

.upload-icon {
  width: 1.25rem;
  height: 1.25rem;
  color: #0d9488;
  margin-right: 0.5rem;
}

.upload-text {
  font-size: 0.875rem;
  color: #374151;
  font-weight: 500;
}

.file-input-hidden {
  display: none;
}

.file-name {
  font-size: 0.875rem;
  color: #0d9488;
  font-weight: 500;
}

.submit-button {
  width: 100%;
  background: #0d9488;
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
}

.submit-button:hover {
  background: #0f766e;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.submit-button:active {
  background: #115e59;
}

.posts-feed {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.post-card {
  background: white;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 1.25rem;
  border: 1px solid #f3f4f6;
  transition: box-shadow 0.2s;
}

.post-card:hover {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.post-header {
  display: flex;
  align-items: flex-start;
  margin-bottom: 0.75rem;
}

.avatar {
  width: 3rem;
  height: 3rem;
  background: linear-gradient(135deg, #5eead4 0%, #0d9488 100%);
  border-radius: 50%;
  margin-right: 0.75rem;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.avatar-icon {
  width: 1.5rem;
  height: 1.5rem;
  color: white;
}

.post-info {
  flex: 1;
}

.post-title {
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.25rem 0;
}

.post-date {
  font-size: 0.75rem;
  color: #0d9488;
  font-weight: 500;
  margin: 0;
}

.post-content {
  color: #374151;
  line-height: 1.625;
  margin: 0 0 0.75rem 3.75rem;
}

.post-image-container {
  margin-left: 3.75rem;
}

.post-image {
  border-radius: 0.5rem;
  width: 100%;
  border: 1px solid #e5e7eb;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.empty-state {
  background: #f9fafb;
  border-radius: 0.5rem;
  padding: 2rem;
  text-align: center;
  border: 2px dashed #d1d5db;
}

.empty-icon {
  width: 4rem;
  height: 4rem;
  color: #9ca3af;
  margin: 0 auto 0.75rem;
}

.empty-title {
  color: #4b5563;
  font-weight: 500;
  margin: 0 0 0.25rem 0;
}

.empty-subtitle {
  color: #6b7280;
  font-size: 0.875rem;
  margin: 0;
}
</style>
