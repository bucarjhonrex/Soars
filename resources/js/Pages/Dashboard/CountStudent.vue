<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const totalStudents = ref(0);
const pendingAdmissions = ref(0);
const completedAdmissions = ref(0);

const fetchStats = async () => {
    try {
        const response = await axios.get('/dashboard/index');
        totalStudents.value = response.data.totalStudents;
        pendingAdmissions.value = response.data.pendingAdmissions;
        completedAdmissions.value = response.data.completedAdmissions;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchStats();
});
</script>

<template>
    <section class="stats-section">
        <div class="stats-grid">
            <!-- Total Students Card -->
            <div class="stat-card card-teal">
                <div class="stat-card-inner">
                    <div class="stat-icon-wrapper icon-teal">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-value">{{ totalStudents }}</h3>
                    </div>
                </div>
                <div class="stat-bar bar-teal"></div>
            </div>

            <!-- Pending Admissions Card -->
            <div class="stat-card card-orange">
                <div class="stat-card-inner">
                    <div class="stat-icon-wrapper icon-orange">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Pending Admissions</p>
                        <h3 class="stat-value">{{ pendingAdmissions }}</h3>
                    </div>
                </div>
                <div class="stat-bar bar-orange"></div>
            </div>

            <!-- Completed Admissions Card -->
            <div class="stat-card card-green">
                <div class="stat-card-inner">
                    <div class="stat-icon-wrapper icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Completed Admissions</p>
                        <h3 class="stat-value">{{ completedAdmissions }}</h3>
                    </div>
                </div>
                <div class="stat-bar bar-green"></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.stats-section {
    margin-bottom: 24px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.stat-card-inner {
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1);
}

.icon-teal {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.icon-orange {
    background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
    box-shadow: 0 4px 12px rgba(251, 146, 60, 0.3);
}

.icon-green {
    background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
    box-shadow: 0 4px 12px rgba(74, 222, 128, 0.3);
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 8px 0;
}

.stat-value {
    font-size: 36px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1;
}

.stat-bar {
    height: 4px;
}

.bar-teal {
    background: linear-gradient(90deg, #14b8a6 0%, #0d9488 100%);
}

.bar-orange {
    background: linear-gradient(90deg, #fb923c 0%, #f97316 100%);
}

.bar-green {
    background: linear-gradient(90deg, #4ade80 0%, #22c55e 100%);
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
