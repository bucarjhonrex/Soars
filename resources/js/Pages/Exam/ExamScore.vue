<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const score = ref(null);
const passingScore = ref(75);
const status = ref('Awaiting Results');
const message = ref('');
const canProceed = ref(false);

const isPassed = computed(() => {
    return score.value !== null && score.value >= passingScore.value;
});

onMounted(async () => {
    try {
        const res = await axios.get('/student/exam-score');

        score.value = res.data.score;
        passingScore.value = res.data.passing_score || 75;
        status.value = res.data.status;

        // Determine pass/fail and set message
        if (score.value === null) {
            canProceed.value = false;
            message.value = 'You did not pass the entrance exam. You cannot proceed to application.';
            status.value = 'Awaiting Results';
        } else if (score.value < passingScore.value) {
            canProceed.value = false;
            message.value = `You did not pass the entrance exam (${score.value}/${passingScore.value}). You cannot proceed to application.`;
            status.value = 'Failed';
        } else {
            canProceed.value = true;
            message.value = `Congratulations! You passed the entrance exam (${score.value}/${passingScore.value}). You can proceed to application.`;
            status.value = 'Passed';
        }
    } catch (error) {
        console.error('Error fetching exam score:', error);
    }
});
</script>

<template>
    <section class="exam-section">
        <div class="container">
            <div class="card shadow">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-chart-line"></i>
                        Exam Score
                    </h2>
                </div>
                <div class="card-body">
                    <div class="score-row">
                        <div class="score-label">
                            <i class="fas fa-star"></i>
                            Your Score:
                        </div>
                        <div class="score-value">
                            <span class="score-number">
                                {{ score !== null ? score : '--' }}
                            </span>
                            <span class="score-total">/ {{ passingScore }}</span>
                        </div>
                    </div>

                    <div class="score-divider"></div>

                    <div class="score-row">
                        <div class="score-label">
                            <i class="fas fa-trophy"></i>
                            Passing Score:
                        </div>
                        <div class="score-value">
                            <span class="passing-score-number">{{ passingScore }}</span>
                        </div>
                    </div>

                    <div class="score-divider"></div>

                    <div class="score-row">
                        <div class="score-label">
                            <i class="fas fa-info-circle"></i>
                            Status:
                        </div>
                        <div class="score-value">
                            <span
                                class="status-badge"
                                :class="{
                                    'status-pass': status === 'Passed',
                                    'status-fail': status === 'Failed',
                                    'status-waiting': status === 'Awaiting Results'
                                }"
                            >
                                <i :class="{
                                    'fas fa-check-circle': status === 'Passed',
                                    'fas fa-times-circle': status === 'Failed',
                                    'fas fa-hourglass-half': status === 'Awaiting Results'
                                }"></i>
                                {{ status }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="result-message-box"
                        :class="{
                            'message-pass': canProceed,
                            'message-fail': !canProceed && score !== null,
                            'message-waiting': score === null
                        }"
                    >
                        <i :class="{
                            'fas fa-check-circle': canProceed,
                            'fas fa-exclamation-circle': !canProceed && score !== null,
                            'fas fa-lightbulb': score === null
                        }"></i>
                        <p>{{ message }}</p>
                    </div>

                    <div v-if="canProceed" class="action-button-container">
                        <button class="proceed-button" @click="$inertia.visit(route('Application'))">
                            <i class="fas fa-arrow-right"></i>
                            Proceed to Application
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.exam-section {
    width: 100%;
}

.container {
    width: 100%;
    margin: 0 auto;
}

.card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.card:hover {
    border-color: #14b8a6;
    box-shadow: 0 8px 24px rgba(20, 184, 166, 0.15);
    transform: translateY(-2px);
}

.shadow {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    padding: 20px 28px;
    border-bottom: 3px solid #0d9488;
}

.card-header h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-header h2 i {
    font-size: 24px;
}

.card-body {
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.score-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
    border-radius: 12px;
    border-left: 5px solid #14b8a6;
    transition: all 0.3s ease;
}

.score-row:hover {
    background: linear-gradient(135deg, #ccfbf1 0%, #f0fdfa 100%);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.15);
}

.score-label {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 12px;
}

.score-label i {
    color: #14b8a6;
    font-size: 20px;
}

.score-value {
    display: flex;
    align-items: baseline;
    gap: 6px;
}

.score-number {
    font-size: 32px;
    font-weight: 700;
    color: #14b8a6;
    line-height: 1;
}

.score-total {
    font-size: 18px;
    font-weight: 600;
    color: #6b7280;
}

.passing-score-number {
    font-size: 24px;
    font-weight: 700;
    color: #0d9488;
    line-height: 1;
}

.score-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, #14b8a6 50%, transparent 100%);
    margin: 8px 0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 24px;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.status-pass {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 2px solid #6ee7b7;
}

.status-fail {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 2px solid #fca5a5;
}

.status-waiting {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 2px solid #fcd34d;
}

.status-badge:hover {
    transform: scale(1.05);
}

.status-pass:hover {
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.status-fail:hover {
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.status-waiting:hover {
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.result-message-box {
    border-radius: 12px;
    padding: 18px 22px;
    display: flex;
    gap: 14px;
    align-items: flex-start;
    margin-top: 8px;
    transition: all 0.3s ease;
    border: 2px solid;
}

.message-pass {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-color: #6ee7b7;
}

.message-pass i {
    color: #065f46;
    font-size: 22px;
}

.message-pass p {
    color: #065f46;
}

.message-fail {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-color: #fca5a5;
}

.message-fail i {
    color: #991b1b;
    font-size: 22px;
}

.message-fail p {
    color: #991b1b;
}

.message-waiting {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-color: #93c5fd;
}

.message-waiting i {
    color: #1e40af;
    font-size: 20px;
}

.message-waiting p {
    color: #1e3a8a;
}

.result-message-box:hover {
    transform: translateY(-2px);
}

.message-pass:hover {
    background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

.message-fail:hover {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}

.message-waiting:hover {
    background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.result-message-box i {
    flex-shrink: 0;
    margin-top: 2px;
}

.result-message-box p {
    margin: 0;
    font-size: 15px;
    line-height: 1.6;
    font-weight: 600;
}

.action-button-container {
    display: flex;
    justify-content: center;
    margin-top: 12px;
}

.proceed-button {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.proceed-button:hover {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(20, 184, 166, 0.4);
}

.proceed-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);
}

.proceed-button i {
    font-size: 18px;
}

@media (max-width: 640px) {
    .score-row {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
        padding: 18px 20px;
    }

    .card-body {
        padding: 20px;
    }

    .card-header {
        padding: 18px 20px;
    }

    .score-number {
        font-size: 28px;
    }

    .passing-score-number {
        font-size: 20px;
    }

    .proceed-button {
        width: 100%;
        justify-content: center;
    }
}
</style>
