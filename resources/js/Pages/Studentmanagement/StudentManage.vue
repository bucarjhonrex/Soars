<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';

// Modals
const showAddModal = ref(false);
const showEditModal = ref(false);
const openAdd = () => showAddModal.value = true;
const closeAdd = () => showAddModal.value = false;
const openModal = () => showEditModal.value = true;
const closeModal = () => showEditModal.value = false;

// Students
const students = ref([]);
const search = ref('');
const selectedStudent = reactive({
  id: null,
  fname: '',
  lname: '',
  mname: '',
  email: '',
  phone_number: '',
  course_id: null
});

// Courses
const courses = ref([
  { id: 1, course: 'BSIT' },
  { id: 2, course: 'BSCS' },
  { id: 3, course: 'BSIS' }
]);

// Load students
const loadStudents = async () => {
  try {
    const res = await axios.get('/studend');
    students.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

// Load courses
const loadCourses = async () => {
  try {
    const res = await axios.get('/courses');
    courses.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

// Open edit modal
const openEditModal = (student) => {
  Object.assign(selectedStudent, student);
  showEditModal.value = true;
};

// Save edit
const saveEdit = async () => {
  try {
    await axios.put(`/students/${selectedStudent.id}`, selectedStudent);
    Object.assign(selectedStudent, {
      id: null,
      fname: '',
      lname: '',
      mname: '',
      email: '',
      phone_number: '',
      course_id: null
    });
    await loadStudents();
    showEditModal.value = false;
  } catch (err) {
    console.error(err);
  }
};

// Delete student
const deleteStudent = async (id) => {
  if (!confirm('Delete this student?')) return;
  try {
    await axios.delete(`/students/${id}`);
    await loadStudents();
  } catch (err) {
    console.error(err);
  }
};

// Computed filtered students
const filteredStudents = computed(() => {
  return students.value.filter(s =>
    (s.fname + ' ' + s.lname).toLowerCase().includes(search.value.toLowerCase()) ||
    s.email.toLowerCase().includes(search.value.toLowerCase())
  );
});

// On mounted
onMounted(() => {
  loadStudents();
  loadCourses();
});

const newStudent = reactive({
  fname: '',
  lname: '',
  mname: '',
  email: '',
  password: '',
  phone_number: '',
  first_course_applied_id: null,
  second_course_applied_id: null,
  third_course_applied_id: null,
  classification: '',
  student_type: '',
});

// Generate random password
const generatePassword = () => {
  newStudent.password = Math.random().toString(36).slice(-8);
};

// Save new student
const saveNewStudent = async () => {
  try {
    await axios.post('/studend', newStudent);
    Object.assign(newStudent, {
      fname: '',
      lname: '',
      mname: '',
      email: '',
      password: '',
      phone_number: '',
      first_course_applied_id: null,
      second_course_applied_id: null,
      third_course_applied_id: null,
      classification: '',
      student_type: '',
    });
    closeAdd();
    loadStudents();
  } catch (err) {
    console.error(err);
  }
};
</script>

<template>
  <section class="student-management">
    <!-- Header Section -->
    <div class="section-header">
      <div class="header-content">
        <div class="header-icon">
          <i class="fas fa-user-graduate"></i>
        </div>
        <div>
          <h2 class="section-title">Student Management</h2>
          <p class="section-subtitle">Manage and organize student records</p>
        </div>
      </div>
      <button class="btn-add" @click="openAdd">
        <i class="fas fa-plus"></i>
        Add New Student
      </button>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
      <div class="search-wrapper">
        <i class="fas fa-search search-icon"></i>
        <input
          type="text"
          v-model="search"
          placeholder="Search by name or email..."
          class="search-input"
        >
      </div>
    </div>

    <!-- Students Table -->
    <div class="card">
      <div class="table-container">
        <table class="student-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Course</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="stu in filteredStudents" :key="stu.id" class="table-row">
              <td>
                <span class="id-badge">{{ stu.id }}</span>
              </td>
              <td>
                <div class="student-info">
                  <div class="avatar">
                    {{ stu.fname.charAt(0) }}{{ stu.lname.charAt(0) }}
                  </div>
                  <span class="student-name">{{ stu.fname }} {{ stu.lname }}</span>
                </div>
              </td>
              <td>
                <span class="email-text">{{ stu.email }}</span>
              </td>
              <td>
                <span class="course-badge">{{ stu.course }}</span>
              </td>
              <td>
                <span class="status-badge">{{ stu.status }}</span>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="btn-edit" @click="openEditModal(stu)">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn-delete" @click="deleteStudent(stu.id)">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Edit Student Modal -->
  <Modal :show="showEditModal" @close="closeModal">
    <div class="modal-wrapper">
      <div class="modal-header">
        <div class="header-icon-small">
          <i class="fas fa-user-edit"></i>
        </div>
        <div>
          <h5 class="modal-title">Edit Student</h5>
          <p class="modal-subtitle">Update student information</p>
        </div>
      </div>

      <div class="modal-body">
        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-user"></i>
            <span>Personal Information</span>
          </div>

          <div class="form-row two-cols">
            <div class="form-group">
              <label class="form-label">
                <i class="far fa-user"></i>
                First Name
              </label>
              <input type="text" v-model="selectedStudent.fname" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="far fa-user"></i>
                Last Name
              </label>
              <input type="text" v-model="selectedStudent.lname" class="form-input">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="far fa-user"></i>
              Middle Name
            </label>
            <input type="text" v-model="selectedStudent.mname" class="form-input">
          </div>
        </div>

        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-info-circle"></i>
            <span>Contact & Course Details</span>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="far fa-envelope"></i>
              Email Address
            </label>
            <input type="email" v-model="selectedStudent.email" class="form-input">
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-phone"></i>
              Contact Number
            </label>
            <input type="text" v-model="selectedStudent.phone_number" class="form-input">
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-graduation-cap"></i>
              Course
            </label>
            <select v-model="selectedStudent.course_id" class="form-input">
              <option value="">Select Course</option>
              <option v-for="c in courses" :key="c.id" :value="c.id">{{ c.course }}</option>
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-cancel" @click="closeModal">
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

  <!-- Add Student Modal -->
  <Modal :show="showAddModal" @close="closeAdd">
    <div class="modal-wrapper">
      <div class="modal-header">
        <div class="header-icon-small">
          <i class="fas fa-user-plus"></i>
        </div>
        <div>
          <h5 class="modal-title">Add New Student</h5>
          <p class="modal-subtitle">Register a new student to the system</p>
        </div>
      </div>

      <div class="modal-body">
        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-user"></i>
            <span>Personal Information</span>
          </div>

          <div class="form-row two-cols">
            <div class="form-group">
              <label class="form-label">
                <i class="far fa-user"></i>
                First Name
              </label>
              <input type="text" v-model="newStudent.fname" class="form-input" placeholder="Enter first name">
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="far fa-user"></i>
                Last Name
              </label>
              <input type="text" v-model="newStudent.lname" class="form-input" placeholder="Enter last name">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="far fa-user"></i>
              Middle Name
            </label>
            <input type="text" v-model="newStudent.mname" class="form-input" placeholder="Enter middle name">
          </div>
        </div>

        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-envelope"></i>
            <span>Contact Information</span>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="far fa-envelope"></i>
              Email Address
            </label>
            <input type="email" v-model="newStudent.email" class="form-input" placeholder="student@example.com">
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-phone"></i>
              Contact Number
            </label>
            <input type="text" v-model="newStudent.phone_number" class="form-input" placeholder="+63 912 345 6789">
          </div>
        </div>

        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-graduation-cap"></i>
            <span>Course Preferences</span>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-medal"></i>
              1st Choice
            </label>
            <select v-model="newStudent.first_course_applied_id" class="form-input">
              <option disabled :value="null">Select Course</option>
              <option v-for="c in courses" :key="c.id" :value="c.id">{{ c.course }}</option>
            </select>
          </div>

          <div class="form-row two-cols">
            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-medal"></i>
                2nd Choice
              </label>
              <select v-model="newStudent.second_course_applied_id" class="form-input">
                <option disabled :value="null">Select Course</option>
                <option v-for="c in courses" :key="c.id" :value="c.id">{{ c.course }}</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-medal"></i>
                3rd Choice
              </label>
              <select v-model="newStudent.third_course_applied_id" class="form-input">
                <option disabled :value="null">Select Course</option>
                <option v-for="c in courses" :key="c.id" :value="c.id">{{ c.course }}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-tags"></i>
            <span>Classification & Type</span>
          </div>

          <div class="form-row two-cols">
            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-layer-group"></i>
                Classification
              </label>
              <select v-model="newStudent.classification" class="form-input">
                <option disabled value="">Select Classification</option>
                <option value="New">New</option>
                <option value="Old">Old</option>
                <option value="Transferee">Transferee</option>
                <option value="Returnee">Returnee</option>
                <option value="Shiftee">Shiftee</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-user-tag"></i>
                Student Type
              </label>
              <select v-model="newStudent.student_type" class="form-input">
                <option disabled value="">Select Student Type</option>
                <option value="Local">Local</option>
                <option value="Online">Online</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-section">
          <div class="section-label">
            <i class="fas fa-lock"></i>
            <span>Account Security</span>
          </div>

          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-key"></i>
              Password
            </label>
            <div class="password-input-group">
              <input type="text" v-model="newStudent.password" class="form-input" readonly placeholder="Click generate">
              <button class="btn-generate" @click="generatePassword">
                <i class="fas fa-sync-alt"></i>
                Generate
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-cancel" @click="closeAdd">
          <i class="fas fa-times"></i>
          Cancel
        </button>
        <button class="btn btn-save" @click="saveNewStudent">
          <i class="fas fa-check"></i>
          Add Student
        </button>
      </div>
    </div>
  </Modal>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* Main Section */
.student-management {
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

/* Search Bar */
.search-container {
  margin-bottom: 24px;
}

.search-wrapper {
  position: relative;
  max-width: 500px;
}

.search-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 16px;
}

.search-input {
  width: 100%;
  padding: 14px 16px 14px 48px;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 14px;
  transition: all 0.2s ease;
  outline: none;
}

.search-input:focus {
  border-color: #14b8a6;
  box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
}

.search-input::placeholder {
  color: #9ca3af;
}

/* Card */
.card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  border: 1px solid #f0f0f0;
}

/* Table */
.table-container {
  overflow-x: auto;
}

.student-table {
  width: 100%;
  border-collapse: collapse;
}

.student-table thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.student-table th {
  padding: 16px 20px;
  text-align: left;
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.student-table td {
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

.student-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.avatar {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  color: white;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
}

.student-name {
  font-weight: 600;
  color: #1f2937;
}

.email-text {
  color: #6b7280;
}

.course-badge {
  display: inline-block;
  padding: 6px 14px;
  background: #ede9fe;
  color: #7c3aed;
  border-radius: 8px;
  font-weight: 600;
  font-size: 12px;
}

.status-badge {
  display: inline-block;
  padding: 6px 14px;
  background: #ccfbf1;
  color: #0f766e;
  border-radius: 8px;
  font-weight: 600;
  font-size: 12px;
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
}

.modal-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Form Sections */
.form-section {
  margin-bottom: 28px;
  padding-bottom: 24px;
  border-bottom: 2px solid #f0f0f0;
}

.form-section:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.section-label {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 16px;
  color: #14b8a6;
  font-weight: 700;
  font-size: 14px;
}

.section-label i {
  font-size: 16px;
}

/* Form Groups */
.form-row {
  margin-bottom: 16px;
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
  margin-bottom: 16px;
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

select.form-input {
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2314b8a6' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 40px;
}

/* Password Input Group */
.password-input-group {
  display: flex;
  gap: 8px;
}

.password-input-group .form-input {
  flex: 1;
}

.btn-generate {
  padding: 12px 20px;
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.btn-generate:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
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

}
</style>
