<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import CountStudent from './Dashboard/CountStudent.vue';
import RecentActivity from './Dashboard/RecentActivity.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="dashboard-title">
                <i class="fas fa-chart-line title-icon"></i>
                Dashboard
            </h2>
        </template>

        <div class="dashboard-container">
            <CountStudent />
            <RecentActivity />
        </div>
    </AdminAuthenticatedLayout>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.dashboard-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
}

.title-icon {
    margin-right: 12px;
    color: #14b8a6;
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 24px;
}
</style>
