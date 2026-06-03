<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import Modal from "@/Components/Modal.vue";

// Modals
const showAddModal = ref(false);
const showEditModal = ref(false);
const openAdd = () => showAddModal.value = true;
const closeAdd = () => showAddModal.value = false;
const openEdit = () => showEditModal.value = true;
const closeEdit = () => showEditModal.value = false;

// Courses
const courses = ref([]);
const selectedCourse = reactive({
  id: null,
  course: '',
  slots: 0
});

// Reactive new course form
const newCourse = reactive({
  course: '',
  slots: 0
});

// Load courses
const loadCourses = async () => {
  try {
    const res = await axios.get('/courses');
    courses.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

// Add new course
const addCourse = async () => {
  try {
    await axios.post('/courses', {
      course: newCourse.course,
      slots: newCourse.slots
    });
    // Reset form
    newCourse.course = '';
    newCourse.slots = 0;
    closeAdd();
    loadCourses();
  } catch (err) {
    console.error(err);
  }
};

// Open edit modal
const editCourse = (course) => {
  selectedCourse.id = course.id;
  selectedCourse.course = course.course;
  selectedCourse.slots = course.slots;
  showEditModal.value = true;
};

// Save edited course
const saveEdit = async () => {
  try {
    await axios.put(`/courses/${selectedCourse.id}`, {
      course: selectedCourse.course,
      slots: selectedCourse.slots
    });
    closeEdit();
    loadCourses();
  } catch (err) {
    console.error(err);
  }
};

// Delete course
const deleteCourse = async (id) => {
  if (!confirm('Delete this course?')) return;
  try {
    await axios.delete(`/courses/${id}`);
    loadCourses();
  } catch (err) {
    console.error(err);
  }
};

// On mounted
onMounted(() => {
  loadCourses();
});
</script>

<template>
  <section class="course-management">
    <!-- Header Section -->
    <div class="section-header">
      <div class="header-content">
        <div class="header-icon">
          <i class="fas fa-book-open"></i>
        </div>
        <div>
          <h2 class="section-title">Course Management</h2>
          <p class="section-subtitle">Manage academic programs and available slots</p>
        </div>
      </div>
      <button class="btn-add" @click="openAdd">
        <i class="fas fa-plus"></i>
        Add New Course
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon total">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">{{ courses.length }}</h3>
          <p class="stat-label">Total Courses</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon slots">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">{{ courses.reduce((sum, c) => sum + c.slots, 0) }}</h3>
          <p class="stat-label">Available Slots</p>
        </div>
      </div>
    </div>

    <!-- Courses Table -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-list"></i>
          All Courses
        </h3>
      </div>
      <div class="table-container">
        <table class="course-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Course Name</th>
              <th>Available Slots</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="courses.length === 0">
              <td colspan="4" class="no-data">
                <i class="fas fa-inbox"></i>
                <p>No courses available</p>
              </td>
            </tr>
            <tr v-for="course in courses" :key="course.id" class="table-row">
              <td>
                <span class="id-badge">{{ course.id }}</span>
              </td>
              <td>
                <div class="course-info">
                  <div class="course-icon">
                    <i class="fas fa-book"></i>
                  </div>
                  <span class="course-name">{{ course.course }}</span>
                </div>
              </td>
              <td>
                <div class="slots-info">
                  <span class="slots-badge">
                    <i class="fas fa-chair"></i>
                    {{ course.slots }} slots
                  </span>
                </div>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="btn-edit" @click="editCourse(course)">
                    <i class="fas fa-edit"></i>
                    Edit
                  </button>
                  <button class="btn-delete" @click="deleteCourse(course.id)">
                    <i class="fas fa-trash"></i>
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ADD COURSE MODAL -->
    <Modal :show="showAddModal" @close="closeAdd">
      <div class="modal-wrapper">
        <div class="modal-header">
          <div class="header-icon-small">
            <i class="fas fa-plus-circle"></i>
          </div>
          <div>
            <h5 class="modal-title">Add New Course</h5>
            <p class="modal-subtitle">Create a new academic program</p>
          </div>
        </div>

        <div class="modal-body">
          <div class="form-section">
            <div class="section-label">
              <i class="fas fa-info-circle"></i>
              <span>Course Details</span>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-book"></i>
                Course Name
              </label>
              <input
                type="text"
                class="form-input"
                v-model="newCourse.course"
                placeholder="e.g., Bachelor of Science in Information Technology"
              >
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-users"></i>
                Available Slots
              </label>
              <input
                type="number"
                class="form-input"
                v-model="newCourse.slots"
                placeholder="Enter number of available slots"
                min="0"
              >
            </div>

            <!-- Slot Preview -->
            <div class="slot-preview" v-if="newCourse.slots > 0">
              <div class="preview-icon">
                <i class="fas fa-info-circle"></i>
              </div>
              <p class="preview-text">
                This course will have <strong>{{ newCourse.slots }} available slots</strong> for students.
              </p>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-cancel" @click="closeAdd">
            <i class="fas fa-times"></i>
            Cancel
          </button>
          <button class="btn btn-save" @click="addCourse">
            <i class="fas fa-check"></i>
            Add Course
          </button>
        </div>
      </div>
    </Modal>

    <!-- EDIT COURSE MODAL -->
    <Modal :show="showEditModal" @close="closeEdit">
      <div class="modal-wrapper">
        <div class="modal-header">
          <div class="header-icon-small">
            <i class="fas fa-edit"></i>
          </div>
          <div>
            <h5 class="modal-title">Edit Course</h5>
            <p class="modal-subtitle">Update course information</p>
          </div>
        </div>

        <div class="modal-body">
          <div class="form-section">
            <div class="section-label">
              <i class="fas fa-info-circle"></i>
              <span>Course Details</span>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-book"></i>
                Course Name
              </label>
              <input
                type="text"
                class="form-input"
                v-model="selectedCourse.course"
                placeholder="Edit course name"
              >
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-users"></i>
                Available Slots
              </label>
              <input
                type="number"
                class="form-input"
                v-model="selectedCourse.slots"
                placeholder="Edit slot count"
                min="0"
              >
            </div>

            <!-- Slot Preview -->
            <div class="slot-preview" v-if="selectedCourse.slots > 0">
              <div class="preview-icon">
                <i class="fas fa-info-circle"></i>
              </div>
              <p class="preview-text">
                This course will have <strong>{{ selectedCourse.slots }} available slots</strong> for students.
              </p>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-cancel" @click="closeEdit">
            <i class="fas fa-times"></i>
            Cancel
          </button>
          <button class="btn btn-save" @click="saveEdit">
            <i class="fas fa-check"></i>
            Save Changes
          </button>
        </div>
      </div>
    </Modal>
  </section>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* Main Section */
.course-management {
  padding: 24px;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Header Section */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding: 24px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  border-radius: 16px;
  color: white;
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.3);
}

.header-content {
  display: flex;
  align-items: center;
  gap: 16px;
}

.header-icon {
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  backdrop-filter: blur(10px);
}

.section-title {
  font-size: 28px;
  font-weight: 700;
  margin: 0;
  letter-spacing: -0.5px;
}

.section-subtitle {
  font-size: 14px;
  margin: 4px 0 0 0;
  opacity: 0.9;
}

.btn-add {
  padding: 12px 24px;
  background: white;
  color: #14b8a6;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-add:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.btn-add:active {
  transform: translateY(0);
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.stat-card {
  background: white;
  padding: 24px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  gap: 20px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  border: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.15);
}

.stat-icon {
  width: 64px;
  height: 64px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  color: white;
}

.stat-icon.total {
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.stat-icon.slots {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.stat-content {
  flex: 1;
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 4px 0;
}

.stat-label {
  font-size: 14px;
  color: #6b7280;
  margin: 0;
  font-weight: 500;
}

/* Card */
.card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  border: 1px solid #f0f0f0;
}

.card-header {
  padding: 20px 24px;
  background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
  border-bottom: 2px solid #e5e7eb;
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

/* Table */
.table-container {
  overflow-x: auto;
}

.course-table {
  width: 100%;
  border-collapse: collapse;
}

.course-table thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.course-table th {
  padding: 16px 20px;
  text-align: left;
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.course-table td {
  padding: 16px 20px;
  font-size: 14px;
  color: #4b5563;
  border-bottom: 1px solid #f3f4f6;
}

.table-row {
  transition: all 0.2s ease;
}

.table-row:hover {
  background: #f0fdfa;
}

.no-data {
  text-align: center;
  padding: 48px 20px !important;
  color: #9ca3af;
}

.no-data i {
  font-size: 48px;
  margin-bottom: 12px;
  opacity: 0.5;
}

.no-data p {
  margin: 0;
  font-size: 16px;
  font-weight: 500;
}

/* Table Elements */
.id-badge {
  display: inline-block;
  padding: 4px 12px;
  background: #f0fdfa;
  color: #14b8a6;
  border-radius: 6px;
  font-weight: 600;
  font-size: 12px;
}

.course-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.course-icon {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  color: white;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
}

.course-name {
  font-weight: 600;
  color: #1f2937;
}

.slots-info {
  display: flex;
  align-items: center;
}

.slots-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 14px;
  background: #ede9fe;
  color: #7c3aed;
  border-radius: 8px;
  font-weight: 600;
  font-size: 13px;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 8px;
}

.btn-edit,
.btn-delete {
  padding: 8px 16px;
  border: none;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
}

.btn-edit {
  background: #dbeafe;
  color: #1e40af;
}

.btn-edit:hover {
  background: #3b82f6;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-delete {
  background: #fee2e2;
  color: #991b1b;
}

.btn-delete:hover {
  background: #ef4444;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Modal Styles */
.modal-wrapper {
  background: white;
  border-radius: 17px;
  max-width: 800px;
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

.modal-header {
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  padding: 24px 32px;
  display: flex;
  align-items: center;
  gap: 16px;
  color: white;
}

.header-icon-small {
  width: 48px;
  height: 48px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  backdrop-filter: blur(10px);
}

.modal-title {
  font-size: 20px;
  font-weight: 700;
  margin: 0;
}

.modal-subtitle {
  font-size: 13px;
  margin: 4px 0 0 0;
  opacity: 0.9;
}

.modal-body {
  padding: 32px;
}

/* Form Sections */
.form-section {
  margin-bottom: 0;
}

.section-label {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
  color: #14b8a6;
  font-weight: 700;
  font-size: 14px;
}

.section-label i {
  font-size: 16px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group:last-child {
  margin-bottom: 0;
}

.form-label {
  font-size: 13px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-label i {
  color: #14b8a6;
  font-size: 12px;
}

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

/* Slot Preview */
.slot-preview {
  margin-top: 20px;
  padding: 16px;
  background: #f0fdfa;
  border-radius: 10px;
  border: 1px solid #ccfbf1;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.preview-icon {
  width: 32px;
  height: 32px;
  background: white;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #14b8a6;
  font-size: 16px;
  flex-shrink: 0;
}

.preview-text {
  flex: 1;
  font-size: 13px;
  color: #0d9488;
  margin: 0;
  line-height: 1.6;
}

.preview-text strong {
  font-weight: 700;
  color: #0f766e;
}

/* Modal Footer */
.modal-footer {
  padding: 20px 32px;
  background: #f9fafb;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  border-top: 1px solid #e5e7eb;
}

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
@media (max-width: 768px) {
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .btn-add {
    width: 100%;
    justify-content: center;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .modal-body {
    padding: 24px;
  }

  .modal-footer {
    flex-direction: column-reverse;
  }

  .btn {
    width: 100%;
    justify-content: center;
  }

  .action-buttons {
    flex-direction: column;
  }

  .btn-edit,
  .btn-delete {
    width: 100%;
    justify-content: center;
  }
}
</style>
