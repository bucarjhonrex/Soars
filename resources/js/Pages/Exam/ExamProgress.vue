<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const progress = ref({
    fully_registered: true,
    exam_scheduled: false,
    results_released: false,
    application_submitted: false,
    status_color: 'gray'
});

onMounted(() => {
    axios.get('/Progress') // call the same route
        .then(res => progress.value = res.data)
        .catch(() => console.log("Error fetching progress"));
});
</script>




<template>
    <section class="exam-section">
        <div class="container">
            <div class="card shadow">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-tasks"></i>
                        Exam Progress
                    </h2>
                </div>
                <div class="card-body">
                    <div class="progress-item completed">
                        <div class="progress-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="progress-content">
                            <p class="progress-title">Fully Registered Account</p>
                            <span class="progress-status status-completed">Completed</span>
                        </div>
                    </div>


                    <div class="progress-item" :class="progress.exam_scheduled ? 'completed' : 'pending'">
                      <div class="progress-icon">
                          <i :class="progress.exam_scheduled ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                      </div>
                      <div class="progress-content">
                          <p class="progress-title">Entrance Exam Schedule</p>
                     <span :class="'progress-status ' + (progress.exam_scheduled ? 'status-completed' : 'status-pending')">
                             {{ progress.exam_scheduled ? "Completed" : "Pending" }}
                         </span>
                     </div>
                    </div>


                    <div class="progress-item" :class="progress.results_released ? 'completed' : 'pending'">
                    <div class="progress-icon">
                        <i :class="progress.results_released ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                            </div>
                     <div class="progress-content">
                     <p class="progress-title">Results Release</p>
                         <span :class="'progress-status ' + (progress.results_released ? 'status-completed' : 'status-pending')">
                            {{ progress.results_released ? "Completed" : "Pending" }}
                           </span>
                             </div>
                        </div>


                    <div class="progress-item" :class="progress.application_submitted ? (progress.status_color === 'red' ? 'failed' : 'completed') : 'pending'">
                        <div class="progress-icon">
                         <i :class="progress.application_submitted ? (progress.status_color === 'red' ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle') : 'far fa-circle'"></i>
                         </div>
                         <div class="progress-content">
                         <p class="progress-title">Application Submitted</p>
                             <span :class="'progress-status ' +
                                (progress.application_submitted ? (progress.status_color === 'red' ? 'status-failed' : 'status-completed') : 'status-pending')">
                               {{ progress.application_submitted ? (progress.status_color === 'red' ? 'Failed' : 'Completed') : 'Pending' }}
                            </span>
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
    gap: 16px;
}

.progress-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 18px 20px;
    background: white;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    position: relative;
}

.progress-item:hover {
    border-color: #14b8a6;
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.1);
}

.progress-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.progress-item.completed .progress-icon {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
}

.progress-item.pending .progress-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.progress-item:hover .progress-icon {
    transform: scale(1.1) rotate(5deg);
}

.progress-content {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}

.progress-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
}

.progress-status {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.status-completed {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border: 1px solid #86efac;
}

.status-pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #fcd34d;
}

.progress-item:hover .progress-status {
    transform: scale(1.05);
}

@media (max-width: 640px) {
    .progress-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .card-header {
        padding: 18px 20px;
    }

    .progress-item {
        padding: 16px;
    }
}
</style>
