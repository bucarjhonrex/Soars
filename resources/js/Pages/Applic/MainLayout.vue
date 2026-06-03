<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

import applicationForm from './partials/applicationForm.vue';
import Documents from './partials/Documents.vue';
import EducationForm from './partials/EducationForm.vue';
import familyForm from './partials/familyForm.vue';

const activeTab = ref('application');
const canAccessApplication = ref(false);
const isLoading = ref(true);
const examScore = ref(null);
const passingScore = ref(75);

const switchTab = (tab) => {
    activeTab.value = tab;
};

onMounted(async () => {
    try {
        const res = await axios.get('/student/exam-score');
        examScore.value = res.data.score;
        passingScore.value = res.data.passing_score || 75;

        // Check if student passed the exam
        const hasPassed = examScore.value !== null && examScore.value >= passingScore.value;
        canAccessApplication.value = hasPassed;

        // Redirect to dashboard if not passed
        if (!hasPassed) {
            setTimeout(() => {
                router.visit(route('dashboard'));
            }, 3000);
        }
    } catch (error) {
        console.error('Error checking exam score:', error);
        canAccessApplication.value = false;
        router.visit(route('dashboard'));
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <section>
        <div class="container">

            <!-- LOADING STATE -->
            <div v-if="isLoading" class="access-check-box loading-box">
                <div class="spinner"></div>
                <h3>Checking your exam eligibility...</h3>
            </div>

            <!-- ACCESS DENIED - NOT PASSED EXAM -->
            <div v-else-if="!canAccessApplication" class="access-check-box denied-box">
                <div class="icon-wrapper denied-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h2>Access Denied</h2>
                <p class="denied-message">
                    You did not pass the entrance exam ({{ examScore !== null ? examScore : '--' }}/{{ passingScore }}).
                    You cannot proceed to the application.
                </p>
                <p class="redirect-message">
                    <i class="fas fa-info-circle"></i>
                    Redirecting you back to the dashboard in 3 seconds...
                </p>
                <button class="btn-back" @click="router.visit(route('dashboard'))">
                    <i class="fas fa-arrow-left"></i>
                    Go Back Now
                </button>
            </div>

            <!-- APPLICATION FORM - ONLY IF PASSED -->
            <div v-else>
                <!-- SUCCESS MESSAGE -->
                <div class="access-check-box success-box mb-4">
                    <div class="icon-wrapper success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h4>Exam Passed!</h4>
                        <p>You scored {{ examScore }}/{{ passingScore }}. You can now proceed with your application.</p>
                    </div>
                </div>

                <!-- FOLDER TABS -->
                <div class="d-flex align-items-center mb-3">
                    <div class="folder-tabs d-flex gap-2 flex-grow-1">
                        <button
                            class="folder-tab"
                            :class="{ active: activeTab === 'application' }"
                            @click="switchTab('application')"
                        >
                            Application Info
                        </button>

                        <button
                            class="folder-tab"
                            :class="{ active: activeTab === 'education' }"
                            @click="switchTab('education')"
                        >
                            Education Info
                        </button>

                        <button
                            class="folder-tab"
                            :class="{ active: activeTab === 'family' }"
                            @click="switchTab('family')"
                        >
                            Family Info
                        </button>

                        <button
                            class="folder-tab"
                            :class="{ active: activeTab === 'documents' }"
                            @click="switchTab('documents')"
                        >
                            Documents
                        </button>
                    </div>

                    <button class="btn btn-success ms-auto px-4">
                        Upload
                    </button>
                </div>

                <!-- TAB CONTENT -->
                <div class="mt-4">
                    <div v-show="activeTab === 'application'">
                        <applicationForm />
                    </div>

                    <div v-show="activeTab === 'education'">
                        <EducationForm />
                    </div>

                    <div v-show="activeTab === 'family'">
                        <familyForm />
                    </div>

                    <div v-show="activeTab === 'documents'">
                        <Documents />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Access Check Boxes */
.access-check-box {
    background: white;
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    border: 2px solid;
    margin-bottom: 24px;
}

.loading-box {
    border-color: #14b8a6;
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
}

.denied-box {
    border-color: #fca5a5;
    background: linear-gradient(135deg, #fee2e2 0%, #ffffff 100%);
}

.success-box {
    border-color: #6ee7b7;
    background: linear-gradient(135deg, #d1fae5 0%, #ffffff 100%);
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
    padding: 24px 32px;
}

.icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.success-box .icon-wrapper {
    width: 60px;
    height: 60px;
    margin: 0;
    flex-shrink: 0;
}

.denied-icon {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 3px solid #fca5a5;
}

.denied-icon i {
    font-size: 40px;
    color: #991b1b;
}

.success-icon {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 3px solid #6ee7b7;
}

.success-icon i {
    font-size: 32px;
    color: #065f46;
}

.success-box h4 {
    margin: 0 0 8px 0;
    color: #065f46;
    font-size: 20px;
    font-weight: 700;
}

.success-box p {
    margin: 0;
    color: #065f46;
    font-size: 15px;
}

.denied-box h2 {
    color: #991b1b;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 16px;
}

.denied-message {
    color: #991b1b;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 24px;
    line-height: 1.6;
}

.redirect-message {
    color: #dc2626;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 24px;
}

.btn-back {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-back:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #ccfbf1;
    border-top-color: #14b8a6;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-box h3 {
    color: #0d9488;
    font-size: 20px;
    font-weight: 600;
}

/* Folder-style tabs */
.folder-tab {
    background: #e7e7e7;
    border: 1px solid #cfcfcf;
    border-bottom: none;
    padding: 10px 18px;
    border-radius: 8px 8px 0 0;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
}

.folder-tab:hover {
    background: #dcdcdc;
}

.folder-tab.active {
    background: white;
    border-bottom: 1px solid white;
    box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
    font-weight: 600;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.gap-2 {
    gap: 0.5rem;
}

.flex-grow-1 {
    flex-grow: 1;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mt-4 {
    margin-top: 1.5rem;
}

.ms-auto {
    margin-left: auto;
}

.px-4 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.btn-success {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}
</style>
