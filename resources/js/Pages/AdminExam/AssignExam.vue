<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import axios from "axios";

const showModal = ref(false);
const selectedStudent = ref(null);
const examScore = ref("");
const selectedExamId = ref("");

const studentExamId = ref(null);

const openModal = async (student) => {
    selectedStudent.value = student;
    showModal.value = true;

    // Load assigned exam for this student
    const response = await axios.get(`/student-exam/${student.id}`);
    studentExamId.value = response.data.exam_id;
    selectedExamId.value = response.data.exam_id; // lock exam
};


const closeModal = () => {
    showModal.value = false;
    selectedStudent.value = null;
    examScore.value = "";
    selectedExamId.value = "";
};



const submitExamAssignment = () => {
    if (!selectedExamId.value) {
        alert("Please select an exam.");
        return;
    }

    axios.post("/assign-exam", {
        student_id: selectedStudent.value.id,
        exam_id: selectedExamId.value,
        score: examScore.value ? parseInt(examScore.value) : null
    })
    .then((res) => {
        alert(res.data.message || "Student assigned successfully!");
        closeModal();
    })
    .catch((error) => {
        alert(error.response.data.message || "Error assigning exam");
    });
};
</script>


<script>
import axios from "axios";

export default {
    data() {
        return {
            students: [],
            exams: [],
            searchQuery: ""
        };
    },
    computed: {
        filteredStudents() {
            if (!this.searchQuery) return this.students;
            const query = this.searchQuery.toLowerCase();
            return this.students.filter(student =>
                student.fname.toLowerCase().includes(query) ||
                student.lname.toLowerCase().includes(query) ||
                student.email.toLowerCase().includes(query)
            );
        }
    },
    mounted() {
        this.loadStudents();
        this.loadExams();
    },
    methods: {
        loadStudents() {
            axios.get("/exami").then((response) => {
                this.students = response.data;
            });
        },
        loadExams() {
            axios.get("/exams")
                .then((response) => {
                    this.exams = response.data;
                });
        }
    }
};
</script>


<template>
    <section class="assign-exam-section">
        <div class="search-header">
            <label class="header-label"></label>
            <div class="search-container">
                <span class="search-label">Search</span>
                <input
                    v-model="searchQuery"
                    class="search-input"
                    type="text"
                    placeholder="Search students..."
                />
            </div>
        </div>

        <div class="table-container">
            <table class="students-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in filteredStudents" :key="student.id" class="table-row">
                        <td>{{ student.id }}</td>
                        <td>{{ student.fname }}</td>
                        <td>{{ student.lname }}</td>
                        <td>{{ student.mname }}</td>
                        <td>{{ student.email }}</td>
                        <td>
                            <button class="btn-exam-submit" @click="openModal(student)">
                                Exam Submit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Component -->
        <Modal :show="showModal" @close="closeModal">
            <div class="modal-content">
                <h3 class="modal-title">Assign Exam & Submit Score</h3>

                <div v-if="selectedStudent" class="student-info">
                    <p><strong>Student:</strong> {{ selectedStudent.fname }} {{ selectedStudent.lname }}</p>
                    <p><strong>Email:</strong> {{ selectedStudent.email }}</p>
                </div>

                <div class="modal-form">
                    <div class="form-group">
                        <label class="form-label">Select Exam</label>
                    <select
                        v-model="selectedExamId"
                         class="form-select"
                         :disabled="studentExamId !== null"
                                >
                           <option value="">Choose an exam</option>

                               <option
                                   v-for="exam in exams"
                                       :key="exam.id"
                                           :value="exam.id"
                                                   >
                                       {{ exam.station }} - {{ exam.exam_date }} ({{ exam.used_slots }}/{{ exam.slots }})
                                       </option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label class="form-label">Exam Score</label>
                        <input
                            v-model="examScore"
                            type="number"
                            class="form-input"
                            placeholder="Enter score (0-100)"
                            min="0"
                            max="100"
                        />
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="btn-save" @click="submitExamAssignment">
                        Save Assignment
                    </button>
                    <button class="btn-cancel" @click="closeModal">
                        Close
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>

<style scoped>
.assign-exam-section {
    width: 100%;
}

.search-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

.header-label {
    font-weight: 600;
    color: #374151;
}

.search-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.search-label {
    font-size: 0.875rem;
    color: #4b5563;
    font-weight: 500;
}

.search-input {
    width: 220px;
    height: 38px;
    padding: 0.5rem 0.875rem;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.search-input:hover {
    border-color: #99f6e4;
}

.table-container {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.students-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.students-table thead {
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.students-table th {
    padding: 0.875rem 1rem;
    text-align: left;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.students-table td {
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

.btn-exam-submit {
    background: #14b8a6;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-exam-submit:hover {
    background: #0f766e;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);
}

.btn-exam-submit:active {
    transform: translateY(0);
}

/* Modal Styles */
.modal-content {
    padding: 1.5rem;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 1.25rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #14b8a6;
}

.student-info {
    background: #f0fdfa;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
}

.student-info p {
    margin: 0.5rem 0;
    font-size: 0.9375rem;
    color: #374151;
}

.student-info strong {
    color: #0f766e;
}

.modal-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4b5563;
}

.form-select,
.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    background: white;
}

.form-select:focus,
.form-input:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.form-select:hover,
.form-input:hover {
    border-color: #99f6e4;
}

.modal-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.btn-save,
.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-save {
    background: #14b8a6;
    color: white;
}

.btn-save:hover {
    background: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.btn-cancel {
    background: #ef4444;
    color: white;
}

.btn-cancel:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-save:active,
.btn-cancel:active {
    transform: translateY(0);
}
</style>
