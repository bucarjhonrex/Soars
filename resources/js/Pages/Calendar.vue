<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import AssignExam from './AdminExam/AssignExam.vue';
import CreateExam from './AdminExam/CreateExam.vue';
import ExamView from './AdminExam/ExamView.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Exam Management" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="page-header">
                Exam Management
            </h2>
        </template>

        <div class="exam-management-container">
            <!-- Left side: stacked cards -->
            <div class="left-section">
                <div class="exam-card assign-card">
                    <AssignExam />
                </div>
                <div class="exam-card view-card">
                    <ExamView />
                </div>
            </div>

            <!-- Right side: single card -->
            <div class="right-section">
                <div class="exam-card create-card">
                    <CreateExam />
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>

<style scoped>
.page-header {
    font-size: 1.5rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
    padding: 1rem 0;
}

.exam-management-container {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    min-height: calc(100vh - 200px);
}

.left-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.right-section {
    width: 350px;
    flex-shrink: 0;
}

.exam-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.exam-card:hover {
    box-shadow: 0 4px 16px rgba(20, 184, 166, 0.15);
}

.assign-card {
    flex: 0 0 auto;
}

.view-card {
    flex: 1;
    min-height: 400px;
}

.create-card {
    position: sticky;
    top: 1.5rem;
}

@media (max-width: 1024px) {
    .exam-management-container {
        flex-direction: column;
    }

    .right-section {
        width: 100%;
    }

    .create-card {
        position: relative;
        top: 0;
    }
}
</style>
