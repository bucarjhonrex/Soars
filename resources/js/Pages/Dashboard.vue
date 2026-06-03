<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ExamSched from './Exam/ExamSched.vue';
import ExamScore from './Exam/ExamScore.vue';
import ExamProgress from './Exam/ExamProgress.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="dashboard-header">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </h2>
        </template>

        <div class="dashboard-content">
            <ExamSched></ExamSched>
            <ExamScore></ExamScore>
            <ExamProgress></ExamProgress>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.dashboard-header {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 12px;
}

.dashboard-header i {
    color: #14b8a6;
    font-size: 26px;
}

.dashboard-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px 20px;
    display: flex;
    flex-direction: column;
    gap: 28px;
}

@media (max-width: 768px) {
    .dashboard-content {
        padding: 24px 16px;
        gap: 20px;
    }
}
</style>
