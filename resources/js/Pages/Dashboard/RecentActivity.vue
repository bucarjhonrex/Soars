<script setup>
import Modal from '@/Components/Modal.vue';
import allRecentActivity from './partials/allRecentActivity.vue';
import allRecentApplication from './partials/allRecentApplication.vue';
import {ref, onMounted, computed} from 'vue';
import axios from 'axios';

const showModal = ref(false);
const openModal = () => showModal.value = true;
const closeModal = () => showModal.value = false;
const recentApp = ref(false);
const openRecent = () => recentApp.value = true;
const closeRecent = () => recentApp.value = false;

const recetStudents = ref([]);
const fetchRecentStudents = async() => {
    try {
        const response = await axios.get('/dashboard/recent-students');
        recetStudents.value = response.data;
    } catch(error) {
        console.error('Problems with Recent Activity', error)
    }
}

const recentApplications = ref([]);

const fetchRecentApplications = async () => {
    try {
        const response = await axios.get('/dashboard/recent-applications');
        recentApplications.value = response.data;
    } catch(error) {
        console.error('Problems with Recent Applications', error)
    }
}



onMounted(() => {
    fetchRecentStudents();
});

</script>

<template>
    <section class="activity-section">
        <div class="content-grid">
            <div class="content-left">
                <!-- Recent Activity Card -->
                <div class="card">
                    <div class="card-header header-teal">
                        <h3 class="card-title">
                            <i class="fas fa-history"></i>
                            Recent Activity
                        </h3>
                        <a @click="openModal" class="view-all">View All →</a>
                    </div>
                    <div class="activity-list">
                        <div v-if="recetStudents.length === 0" class="no-student">
                            No Recent Activity
                        </div>
                        <div v-for="student in recetStudents" :key="student.id" class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-details">
                                <p class="activity-text">
                                    New student registration:
                                    <span class="student-name">{{student.user.fname}} {{ student.user.lname }}</span>
                                </p>
                                <span class="activity-time">
                                    <i class="far fa-clock"></i>
                                    {{new Date(student.created_at).toLocaleString()}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="content-right">
                <div class="card">
                    <div class="card-header header-teal">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            November 2025
                        </h3>
                        <div class="calendar-nav">
                            <button class="nav-btn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="nav-btn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Modal -->
        <Modal :show="showModal" @close="closeModal">
            <div class="modal-content">
                <h2 class="modal-title">All Recent Activity</h2>
                <div class="modal-body">
                    <div v-if="recetStudents.length === 0" class="no-student">
                        No Recent Activity
                    </div>
                    <div v-for="student in recetStudents" :key="student.id" class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-details">
                            <p class="activity-text">
                                New student registration:
                                <span class="student-name">{{student.user.fname}} {{ student.user.lname }}</span>
                            </p>
                            <span class="activity-time">
                                <i class="far fa-clock"></i>
                                {{new Date(student.created_at).toLocaleString()}}
                            </span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger modal-close" @click="closeModal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </Modal>

    </section>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.activity-section {
    margin-top: 24px;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

.content-left {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Card Styles */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-teal {
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
}

.header-orange {
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
}

.card-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-title i {
    color: #14b8a6;
}

.header-orange .card-title i {
    color: #f97316;
}

.view-all {
    color: #14b8a6;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.view-all:hover {
    color: #0d9488;
    text-decoration: underline;
}

.view-all-orange {
    color: #f97316;
}

.view-all-orange:hover {
    color: #ea580c;
}

/* Activity List */
.activity-list {
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item {
    display: flex;
    gap: 16px;
    padding: 16px;
    border-radius: 10px;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.activity-item:hover {
    background-color: #f0fdfa;
    border-color: #ccfbf1;
}

.activity-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.25);
}

.activity-details {
    flex: 1;
}

.no-student {
    text-align: center;
    padding: 20px;
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
}

.activity-text {
    margin: 0 0 6px 0;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
}

.student-name {
    color: #14b8a6;
    font-weight: 700;
}

.activity-time {
    color: #9ca3af;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Applications List */
.applications-list {
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.application-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
}

.application-item:hover {
    border-color: #fb923c;
    background-color: #fff7ed;
    box-shadow: 0 4px 12px rgba(251, 146, 60, 0.15);
}

.app-info {
    flex: 1;
}

.app-name {
    margin: 0 0 6px 0;
    color: #1f2937;
    font-size: 16px;
    font-weight: 700;
}

.app-course {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.app-course i {
    color: #fb923c;
}

.app-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-approve {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
}

.btn-approve:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
}

.btn-reject {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.btn-reject:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

/* Modal Styles */
.modal-content {
    padding: 24px;
    background: white;
    border-radius: 12px;
    max-width: 800px;
    margin: 0 auto;
}

.modal-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
    text-align: center;
}

.modal-body {
    max-height: 500px;
    overflow-y: auto;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table thead {
    background-color: #f9fafb;
}

.table th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.table td {
    padding: 12px;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:hover {
    background-color: #f9fafb;
}

.text-center {
    text-align: center;
}

.modal-close {
    width: 100%;
    margin-top: 10px;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}
</style>
