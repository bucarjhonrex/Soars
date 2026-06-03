<script setup>
import { ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import axios from "axios";

const showCourseModal = ref(false);
const selectedStudent = ref(null);
const selectedCourseId = ref("");
const scoredStudents = ref([]);
const appliedCourses = ref([]);

// Open modal for a student
const openCourseModal = async (student) => {
    selectedStudent.value = student;
    selectedCourseId.value = student.first_course_applied_id || "";
    showCourseModal.value = true;

    // Load the applied courses names
    try {
        const res = await axios.get(`/student/${student.id}/applied-courses`);
        appliedCourses.value = res.data; // [{id, course}]
    } catch (err) {
        console.error(err);
        appliedCourses.value = [];
    }
};

// Close modal and reset
const closeCourseModal = () => {
    showCourseModal.value = false;
    selectedStudent.value = null;
    selectedCourseId.value = "";
    appliedCourses.value = [];
};

// Load students with scores and applications
const loadEligibleStudents = () => {
    axios.get("/students-eligible-for-course")
        .then(res => {
            scoredStudents.value = res.data;
        })
        .catch(err => console.error(err));
};

// Assign selected course
const assignCourse = () => {
    if (!selectedCourseId.value) {
        alert("Please select a course.");
        return;
    }

    axios.post("/assign-course", {
        student_id: selectedStudent.value.id,
        course_id: selectedCourseId.value
    })
    .then(res => {
        alert(res.data.message || "Course assigned successfully!");
        closeCourseModal();
        loadEligibleStudents(); // refresh table
    })
    .catch(err => {
        alert(err.response?.data?.message || "Error assigning course");
    });
};

onMounted(() => {
    loadEligibleStudents();
});
</script>

<template>
    <section>
        <div class="container">
            <div class="card shadow p-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Exam Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in scoredStudents" :key="student.id">
                            <td>{{ student.id }}</td>
                            <td>{{ student.fname }} {{ student.lname }}</td>
                            <td>{{ student.score }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" @click="openCourseModal(student)">
                                    Assign Course
                                </button>
                            </td>
                        </tr>
                        <tr v-if="scoredStudents.length === 0">
                            <td colspan="4" class="text-center">No eligible students yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <Modal :show="showCourseModal" @close="closeCourseModal">
            <div class="p-4">
                <h5 class="mb-3">Assign Course to {{ selectedStudent?.fname }} {{ selectedStudent?.lname }}</h5>

                <div class="mb-3">
                    <label class="form-label">Select Course</label>
                    <select v-model="selectedCourseId" class="form-select">
                        <option value="">-- Choose a Course --</option>
                        <option v-for="c in appliedCourses" :key="c.id" :value="c.id">
                            {{ c.course }}
                        </option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-success" @click="assignCourse">Save</button>
                    <button class="btn btn-secondary" @click="closeCourseModal">Cancel</button>
                </div>
            </div>
        </Modal>
    </section>
</template>
