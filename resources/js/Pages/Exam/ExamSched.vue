<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const exam = ref(null);

onMounted(async () => {
    const res = await axios.get('/student/exam-schedule');
    exam.value = res.data.exam;
});
</script>


<template>
    <section class="exam-section">
        <div class="container">
            <div class="card shadow">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-calendar-check"></i>
                        Exam Schedule
                    </h2>
                </div>
                <div class="card-body">
                   <div class="info-row">
    <div class="info-label">Date:</div>
    <div class="info-value">
        {{ exam ? exam.exam_date : 'To be announced' }}
    </div>
</div>

<div class="info-row">
    <div class="info-label">Start Time:</div>
    <div class="info-value">
        {{ exam ? exam.start_time : 'To be announced' }}
    </div>
</div>

<div class="info-row">
    <div class="info-label">End Time:</div>
    <div class="info-value">
        {{ exam ? exam.end_time : 'To be announced' }}
    </div>
</div>

<div class="info-row">
    <div class="info-label">Venue:</div>
    <div class="info-value">
        {{ exam ? exam.station : 'To be announced' }}
    </div>
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
    gap: 20px;
}

.info-row {
    display: flex;
    align-items: center;
    padding: 16px;
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
    border-radius: 10px;
    border-left: 4px solid #14b8a6;
    transition: all 0.3s ease;
}

.info-row:hover {
    background: linear-gradient(135deg, #ccfbf1 0%, #f0fdfa 100%);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.1);
}

.info-label {
    font-weight: 600;
    color: #1f2937;
    min-width: 140px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
}

.info-label i {
    color: #14b8a6;
    font-size: 16px;
    width: 20px;
}

.info-value {
    color: #4b5563;
    font-size: 15px;
    flex: 1;
}

@media (max-width: 640px) {
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .info-label {
        min-width: auto;
    }

    .card-body {
        padding: 20px;
    }

    .card-header {
        padding: 18px 20px;
    }
}
</style>
