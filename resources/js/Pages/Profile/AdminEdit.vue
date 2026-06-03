<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="profile-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <h2 class="header-title">My Profile</h2>
                        <p class="header-subtitle">Manage your account settings and preferences</p>
                    </div>
                </div>
            </div>
        </template>

        <div class="profile-container">
            <div class="profile-grid">
                <!-- Profile Information Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon info">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <h3 class="card-title">Profile Information</h3>
                            <p class="card-description">Update your account's profile information and email address</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                        />
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon security">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="card-title">Update Password</h3>
                            <p class="card-description">Ensure your account is using a strong password</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <UpdatePasswordForm />
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="profile-card danger-card">
                    <div class="card-header">
                        <div class="card-icon danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 class="card-title">Delete Account</h3>
                            <p class="card-description">Permanently delete your account and all associated data</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>

            <!-- Side Info Panel -->
            <div class="info-panel">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="info-title">Security Tips</h4>
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Use a strong, unique password
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Keep your email address current
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Review your account regularly
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Never share your credentials
                        </li>
                    </ul>
                </div>

                <div class="info-card help-card">
                    <div class="help-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h4 class="info-title">Need Help?</h4>
                    <p class="help-text">If you have any questions or need assistance with your account, feel free to contact our support team.</p>
                    <button class="help-button">
                        <i class="fas fa-headset"></i>
                        Contact Support
                    </button>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* Profile Header */
.profile-header {
  padding: 32px 0;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  border-radius: 0 0 24px 24px;
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.3);
  animation: slideDown 0.4s ease-out;
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

.header-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  color: white;
}

.header-icon {
  width: 72px;
  height: 72px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.header-title {
  font-size: 32px;
  font-weight: 700;
  margin: 0;
  letter-spacing: -0.5px;
}

.header-subtitle {
  font-size: 15px;
  margin: 6px 0 0 0;
  opacity: 0.95;
  font-weight: 400;
}

/* Profile Container */
.profile-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 32px 24px;
  display: grid;
  grid-template-columns: 1fr 350px;
  gap: 24px;
  animation: fadeIn 0.5s ease-out;
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

/* Profile Grid */
.profile-grid {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* Profile Card */
.profile-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  border: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.profile-card:hover {
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.12);
  transform: translateY(-2px);
}

.danger-card {
  border: 2px solid #fee2e2;
}

.danger-card:hover {
  box-shadow: 0 8px 24px rgba(239, 68, 68, 0.15);
}

/* Card Header */
.card-header {
  padding: 24px 28px;
  background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
  border-bottom: 2px solid #e5e7eb;
  display: flex;
  align-items: flex-start;
  gap: 16px;
}

.danger-card .card-header {
  background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
}

.card-icon {
  width: 52px;
  height: 52px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: white;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-icon.info {
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
}

.card-icon.security {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.card-icon.danger {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.card-title {
  font-size: 20px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 6px 0;
}

.card-description {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

/* Card Body */
.card-body {
  padding: 28px;
}

/* Info Panel */
.info-panel {
  display: flex;
  flex-direction: column;
  gap: 20px;
  animation: fadeInRight 0.6s ease-out;
}

@keyframes fadeInRight {
  from {
    opacity: 0;
    transform: translateX(20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Info Card */
.info-card {
  background: white;
  padding: 24px;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  border: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.info-card:hover {
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.12);
  transform: translateY(-2px);
}

.info-icon {
  width: 56px;
  height: 56px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  color: white;
  margin-bottom: 16px;
  box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.info-title {
  font-size: 18px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 16px 0;
}

.info-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.info-list li {
  padding: 12px 0;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 14px;
  color: #4b5563;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.2s ease;
}

.info-list li:last-child {
  border-bottom: none;
}

.info-list li:hover {
  color: #14b8a6;
  padding-left: 8px;
}

.info-list li i {
  color: #14b8a6;
  font-size: 16px;
  flex-shrink: 0;
}

/* Help Card */
.help-card {
  background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
  border: 2px solid #99f6e4;
}

.help-icon {
  width: 56px;
  height: 56px;
  background: white;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  color: #14b8a6;
  margin-bottom: 16px;
  box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
}

.help-text {
  font-size: 14px;
  color: #0f766e;
  line-height: 1.6;
  margin: 0 0 16px 0;
}

.help-button {
  width: 100%;
  padding: 12px 20px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.help-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(20, 184, 166, 0.4);
}

.help-button:active {
  transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .profile-container {
    grid-template-columns: 1fr;
  }

  .info-panel {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    text-align: center;
  }

  .header-icon {
    width: 64px;
    height: 64px;
    font-size: 32px;
  }

  .header-title {
    font-size: 26px;
  }

  .profile-container {
    padding: 20px 16px;
  }

  .info-panel {
    grid-template-columns: 1fr;
  }

  .card-header {
    flex-direction: column;
    text-align: center;
    align-items: center;
  }

  .card-body {
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .header-title {
    font-size: 22px;
  }

  .header-subtitle {
    font-size: 13px;
  }

  .card-title {
    font-size: 18px;
  }

  .info-card {
    padding: 20px;
  }
}

/* Smooth Scroll Behavior */
* {
  scroll-behavior: smooth;
}

/* Focus States for Accessibility */
button:focus,
input:focus {
  outline: 3px solid rgba(20, 184, 166, 0.3);
  outline-offset: 2px;
}
</style>
