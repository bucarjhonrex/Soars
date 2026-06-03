<script setup>
import Modal from "@/Components/Modal.vue";

</script>

<script>
import { ref } from "vue";
import axios from "axios";

export default {
    data() {
        return {
            exams: [],
            editingExam: null, // holds the selected exam for modal
        };
    },
    mounted() {
        this.loadExams();
        setInterval(() => {
            this.loadExams();
        }, 5000);
    },
    methods: {
        loadExams() {
            axios.get("/exams")
                .then((response) => {
                    this.exams = response.data;
                });
        },

        deleteExam(id) {
            if (!confirm("Are you sure you want to delete this exam?")) return;

            axios.delete(`/exams/${id}`)
                .then(() => {
                    this.exams = this.exams.filter((e) => e.id !== id);
                });
        },

        editExam(exam) {
            // clone so table doesn’t instantly update
            this.editingExam = { ...exam };
        },

        updateExam() {
            axios.put(`/exams/${this.editingExam.id}`, this.editingExam)
                .then(() => {
                    this.editingExam = null;
                    this.loadExams();
                })
                .catch(err => console.error(err));
        }
    }
};
</script>


<template>
    <section class="exam-view-section">
        <h5 class="section-title">Exams</h5>

        <div class="table-container">
            <table class="exam-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Station</th>
                        <th>Status</th>
                        <th>Slots</th>
                        <th>Used Slots</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="exam in exams" :key="exam.id" class="table-row">
                        <td>{{ exam.id }}</td>
                        <td>{{ exam.exam_date }}</td>
                        <td>{{ exam.start_time }}</td>
                        <td>{{ exam.end_time }}</td>
                        <td>{{ exam.station }}</td>
                        <td>
                            <span class="status-badge">{{ exam.status }}</span>
                        </td>
                        <td>{{ exam.slots }}</td>
                        <td>{{ exam.used_slots }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" @click="editExam(exam)">Edit</button>
                                <button class="btn-delete" @click="deleteExam(exam.id)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
<Modal :show="editingExam !== null" @close="editingExam = null">
    <div v-if="editingExam" class="modal-wrapper">
        <!-- Header -->
        <div class="modal-header">
            <div class="header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h2 class="modal-title">Edit Exam Schedule</h2>
                <p class="modal-subtitle">Update exam details and settings</p>
            </div>
        </div>

        <!-- Form Content -->
        <div class="modal-body">
            <!-- Date and Time Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Date & Time</h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="far fa-calendar"></i>
                            Exam Date
                        </label>
                        <input
                            type="date"
                            v-model="editingExam.exam_date"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="form-row two-cols">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="far fa-clock"></i>
                            Start Time
                        </label>
                        <input
                            type="time"
                            v-model="editingExam.start_time"
                            class="form-input"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="far fa-clock"></i>
                            End Time
                        </label>
                        <input
                            type="time"
                            v-model="editingExam.end_time"
                            class="form-input"
                        >
                    </div>
                </div>
            </div>

            <!-- Location & Status Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Location & Status</h3>
                </div>

                <div class="form-row two-cols">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-building"></i>
                            Station
                        </label>
                        <input
                            type="text"
                            v-model="editingExam.station"
                            class="form-input"
                            placeholder="Enter station name"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-info-circle"></i>
                            Status
                        </label>
                        <select v-model="editingExam.status" class="form-input">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Complete">Complete</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Capacity Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-users"></i>
                    <h3>Capacity</h3>
                </div>

                <div class="form-row two-cols">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-chair"></i>
                            Total Slots
                        </label>
                        <input
                            type="number"
                            v-model="editingExam.slots"
                            class="form-input"
                            min="0"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user-check"></i>
                            Used Slots
                        </label>
                        <input
                            type="number"
                            v-model="editingExam.used_slots"
                            class="form-input"
                            min="0"
                        >
                    </div>
                </div>

                <!-- Capacity Indicator -->
                <div class="capacity-indicator">
                    <div class="capacity-bar">
                        <div
                            class="capacity-fill"
                            :style="{width: `${(editingExam.used_slots / editingExam.slots) * 100}%`}"
                        ></div>
                    </div>
                    <p class="capacity-text">
                        {{ editingExam.used_slots }} / {{ editingExam.slots }} slots used
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="modal-footer">
            <button class="btn btn-cancel" @click="editingExam = null">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button class="btn btn-save" @click="updateExam">
                <i class="fas fa-check"></i>
                Save Changes
            </button>
        </div>
    </div>
</Modal>

    </section>
</template>

<style scoped>
.exam-view-section {
    width: 100%;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #14b8a6;
    margin: 0 0 1.25rem 0;
}

.table-container {
    overflow-x: auto;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.exam-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.exam-table thead {
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.exam-table th {
    padding: 0.875rem 1rem;
    text-align: left;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

.exam-table td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    color: #4b5563;
    border-bottom: 1px solid #f3f4f6;
}

.table-row {
    transition: background-color 0.2s ease;
}

.table-row:hover {
    background-color: #f0fdfa;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: #ccfbf1;
    color: #0f766e;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-edit,
.btn-delete {
    padding: 0.375rem 0.875rem;
    border: none;
    border-radius: 4px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #3b82f6;
    color: white;
}

.btn-edit:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.btn-add-exam {
    background: #14b8a6;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-add-exam:hover {
    background: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.btn-add-exam:active {
    transform: translateY(0);
}


/* Modal Wrapper */
.modal-wrapper {
    background: white;
    border-radius: 16px;
    max-width: 700px;
    margin: 0 auto;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.modal-header {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    padding: 28px 32px;
    display: flex;
    align-items: center;
    gap: 20px;
    color: white;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    backdrop-filter: blur(10px);
}

.modal-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
}

.modal-subtitle {
    font-size: 14px;
    margin: 4px 0 0 0;
    opacity: 0.9;
    font-weight: 400;
}

/* Body */
.modal-body {
    padding: 32px;
    max-height: 500px;
    overflow-y: auto;
}

.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
    transition: background 0.2s;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Form Sections */
.form-section {
    margin-bottom: 32px;
    padding-bottom: 28px;
    border-bottom: 2px solid #f0f0f0;
    animation: sectionFadeIn 0.4s ease-out;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

@keyframes sectionFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    color: #14b8a6;
}

.section-header i {
    font-size: 18px;
}

.section-header h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

/* Form Rows */
.form-row {
    margin-bottom: 20px;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-row.two-cols {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

/* Form Labels */
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.2s;
}

.form-label i {
    color: #14b8a6;
    font-size: 12px;
}

/* Form Inputs */
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    color: #1f2937;
    background: white;
    transition: all 0.2s ease;
    outline: none;
}

.form-input:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
    background: #f0fdfa;
}

.form-input:hover:not(:focus) {
    border-color: #cbd5e1;
}

.form-input::placeholder {
    color: #9ca3af;
}

select.form-input {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2314b8a6' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 40px;
}

/* Capacity Indicator */
.capacity-indicator {
    margin-top: 16px;
    padding: 16px;
    background: #f0fdfa;
    border-radius: 10px;
    border: 1px solid #ccfbf1;
}

.capacity-bar {
    width: 100%;
    height: 8px;
    background: #e0f2f1;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 8px;
}

.capacity-fill {
    height: 100%;
    background: linear-gradient(90deg, #14b8a6 0%, #0d9488 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.capacity-text {
    font-size: 13px;
    font-weight: 600;
    color: #0d9488;
    margin: 0;
    text-align: center;
}

/* Footer */
.modal-footer {
    padding: 24px 32px;
    background: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    border-top: 1px solid #e5e7eb;
}

/* Buttons */
.btn {
    padding: 12px 24px;
    border-radius: 10px;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    outline: none;
}

.btn-cancel {
    background: white;
    color: #6b7280;
    border: 2px solid #e5e7eb;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

.btn-cancel:active {
    transform: scale(0.98);
}

.btn-save {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(20, 184, 166, 0.4);
}

.btn-save:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 640px) {
    .form-row.two-cols {
        grid-template-columns: 1fr;
    }

    .modal-header {
        padding: 24px;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 20px 24px;
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

</style>
