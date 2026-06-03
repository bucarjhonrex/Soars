<script setup>
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const user = usePage().props.auth.user;

// load data from backend
const courses = ref([]);
const students = ref([]);

// useForm replaces your old reactive form
const form = useForm({
    student_id: '',
    lrn: '',
    first_course: '',
    second_course: '',
    third_course: '',
    classification: '',
    education_level: '',
    student_type: '',
    remarks: '',

    fname: user.fname || '',
    mname: user.mname || '',
    lname: user.lname || '',
    dob: '',
    email: user.email || '',
    sex: '',
    place_birth: '',
    contact_number:'',
    civil_status: '',
    blood_type: '',
    religion: '',

    permanent_region: '',
    permanent_province: '',
    permanent_city: '',
    permanent_barangay: '',
    permanent_zip: '',
    permanent_household_income: '',

    current_region: '',
    current_province: '',
    current_city: '',
    current_barangay: '',
    current_zip: '',
    current_household_income: '',
});

// FETCH COURSES
const fetchCourses = async () => {
    const res = await axios.get('/courses');
    courses.value = res.data;
};

// FETCH STUDENTS
const fetchStudents = async () => {
    const res = await axios.get('/students');
    students.value = res.data;

    const student = students.value.find(s => s.user.id === user.id);

    if (student) {
        // preload
        form.student_id = student.id;
        form.dob = student.dob || '';
        form.sex = student.gender || '';
        form.place_birth = student.place_birth || '';
        form.contact_number = student.phone_number || '';
        form.civil_status = student.civil_status || '';
        form.blood_type = student.blood_type || '';
        form.religion = student.religion || '';

        // application info
        if (student.application_info) {
            form.lrn = student.application_info.lrn || '';
            form.first_course = student.application_info.first_course_applied || '';
            form.second_course = student.application_info.second_course_applied || '';
            form.third_course = student.application_info.third_course_applied || '';
            form.classification = student.application_info.classification || '';
            form.education_level = student.application_info.education_level || '';
            form.student_type = student.application_info.student_type || '';
            form.remarks = student.application_info.remarks || '';
        }

        // addresses
        student.addresses?.forEach(addr => {
            if (addr.type === "permanent") {
                form.permanent_region = addr.region;
                form.permanent_province = addr.province;
                form.permanent_city = addr.city;
                form.permanent_barangay = addr.barangay;
                form.permanent_zip = addr.zip;
                form.permanent_household_income = addr.household_income;
            }
            if (addr.type === "current") {
                form.current_region = addr.region;
                form.current_province = addr.province;
                form.current_city = addr.city;
                form.current_barangay = addr.barangay;
                form.current_zip = addr.zip;
                form.current_household_income = addr.household_income;
            }
        });
    }
};

// SUBMIT FORM (Inertia version)
const submitApplication = () => {
    form.post(route("submit.application"), {
        onSuccess: () => {
            alert("Application submitted successfully!");
        }
    });
};

onMounted(() => {
    fetchCourses();
    fetchStudents();
});
</script>

<template>
    <form @submit.prevent="submitApplication">
    <section>
           <h5 class="section-header mt-3 mb-3">Application Information</h5>
        <table class="table align-middle">
            <tbody>
            <tr>
              <td><label>LRN</label>
                <input v-model="form.lrn" type="text" class="form-control"></td>
              <td></td>
            </tr>
            <tr>
              <td><label>1st Choice</label>
                <select v-model="form.first_course" name="" id="" class="form-select">
                  <option v-for="course in courses" :key="course.id">{{ course.course }}</option>
                </select>
              </td>
              <td><label>2nd Choice</label>
              <select v-model="form.second_course" name="" id="" class="form-select">
                <option v-for="course in courses" :key="course.id">{{ course.course }}</option>

              </select></td>
              <td><label>3rd Choice</label>
              <select v-model="form.third_course" name="" id="" class="form-select">
                 <option v-for="course in courses" :key="course.id">{{ course.course }}</option>

              </select></td>
            </tr>
          <tr>
             <td><label>Classification</label>
                <select v-model="form.classification" class="form-select">
                  <option selected disabled>Select Classification</option>
                  <option value=" ">New</option>
                  <option value="">Old</option>
                  <option value="">Transferee</option>
                  <option value="">Returnee</option>
                  <option value="">Shiftee</option>
                </select>
              </td>
              <td>
                <label for="">Education level</label>
                <select v-model="form.education_level" name="" id="" class="form-select">
                  <option selected disabled>Select Educational Level</option>
                  <option value="">Elementary School</option>
                  <option value="">Junior High School </option>
                  <option value="">Senior High School </option>
                  <option value="">Bachelors Degree</option>
                  <option value="">Masteral Degree</option>
                </select>
              </td>
              <td>
                <label for="">Student Type</label>
                <select v-model="form.student_type" name="" id="" class="form-select">
                  <option selected disabled>Select Student type</option>
                  <option value="">Local</option>
                  <option value="">Online</option>
                  <option value="">Other</option>
                </select>
              </td>
          </tr>
          </tbody>
          </table>
             <h5 class="section-header mt-4 mb-3">Personal Information</h5>
            <label for="#personal"> Full Name</label>
          <table class="table align-middle">

            <tbody>

            <tr id="personal">

              <td><input disabled type="text" class="form-control" placeholder="First Name" v-model="form.fname"></td>
              <td><input disabled type="text" class="form-control" placeholder="Middle Name" v-model="form.mname"></td>
              <td><input disabled type="text" class="form-control" placeholder="Last Name" v-model="form.lname"></td>
            </tr>
            <tr>
              <td><label>Date of Birth</label><input type="date" class="form-control" v-model="form.dob"></td>
              <td><label>Email</label><input disabled type="email" class="form-control" v-model="form.email"></td>
              <td><label>Select Sex</label>
                <select v-model="form.sex" class="form-select">
                  <option selected disabled>Select Sex</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><label for="">Place of Birth</label><input v-model="form.place_birth" type="text" class="form-control"></td>
              <td><label>Contact Number</label><input v-model="form.contact_number" type="text" class="form-control"></td>
              <td><label for="" >Civil Status</label>
              <select v-model="form.civil_status" name="" id="" class="form-select">
                  <option selected disabled>Select Civil Status</option>
                <option value="">Single</option>
                <option value="">Married</option>
                <option value="">Widowed</option>
                <option value="">Separated</option>
                <option value="">Divorced</option>
              </select>
              </td>
            </tr>
            <tr>
              <td><label for="">Blood type</label>
                <select v-model="form.blood_type" name="" id="" class="form-select">
                  <option selected disabled>Select Blood Type</option>
                  <option value="">A+</option>
                  <option value="">A-</option>
                  <option value="">B+</option>
                  <option value="">B-</option>
                  <option value="">AB+</option>
                  <option value="">AB-</option>
                  <option value="">O+</option>
                  <option value="">O-</option>
                </select>
              </td>
              <td>
                <label for="">Religion</label>
                <input v-model="form.religion" type="text" class="form-control">
              </td>
              <td></td>
            </tr>
            </tbody>
          </table>
            <h5 class="section-header mt-4 mb-3">Complete Address</h5>
          <table class="table align-middle">
            <tbody>
            <tr>
              <td>
                 <small class="address-label">permanent Address</small><br>
                <label for="">Region</label>
              <input  v-model="form.permanent_region" type="text" class="form-control"></td>
              <td>
                <br><label for="">Province</label>
              <input v-model="form.permanent_province" type="text" class="form-control"></td>
              <td>
                <br>
                <label for="">City/Municipality</label>
                <input v-model="form.permanent_city" type="text" class="form-control">
              </td>
              </tr>
              <tr>
              <td>
                <label for="">Barangay</label>
                <input v-model="form.permanent_barangay" type="text" class="form-control">
              </td>
              <td>
                <label for="">Zip Code</label>
                <input v-model="form.permanent_zip" type="text" class="form-control">
              </td>
              </tr>
              <tr>
              <td>
                <label for="">Household per Capital Income</label>
                <input v-model="form.permanent_household_income" type="text" class="form-control">
              </td>
            </tr>

             <tr>
              <td>
                 <small class="address-label">Temporary/Current Address</small><br>
                <label for="">Region</label>
            <input v-model="form.current_region"  type="text" class="form-control">
            </td>
              <td>
                <br><label for="">Province</label>
           <input v-model="form.current_province" type="text" class="form-control">
            </td>

              <td>
                <br>
                <label for="">City/Municipality</label>
               <input v-model="form.current_city" type="text" class="form-control">
              </td>
              </tr>
              <tr>
              <td>
                <label for="">Barangay</label>
                <input v-model="form.current_barangay" type="text" class="form-control">
              </td>
              <td>
                <label for="">Zip Code</label>
                <input v-model="form.current_zip" type="text" class="form-control">
              </td>
              </tr>
              <tr>
              <td>
                <label for="">Household per Capital Income</label>
                <input v-model="form.current_household_income" type="text" class="form-control">
              </td>
            </tr>
            </tbody>
          </table>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-submit">
              Submit Application
            </button>
          </div>
    </section>
    </form>
</template>

<style scoped>
.section-header {
  color: #0d9488;
  font-weight: 600;
  border-left: 4px solid #14b8a6;
  padding-left: 12px;
  margin-bottom: 1.5rem;
}

.address-label {
  font-weight: 600;
  color: #0f766e;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
}

.form-control:focus,
.form-select:focus {
  border-color: #14b8a6;
  box-shadow: 0 0 0 0.2rem rgba(20, 184, 166, 0.25);
}

.btn-submit {
  background: #0d9488;
  color: white;
  padding: 0.75rem 2rem;
  border: none;
  border-radius: 0.375rem;
  font-weight: 600;
  transition: all 0.2s;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn-submit:hover {
  background: #0f766e;
  transform: translateY(-2px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.btn-submit:active {
  background: #115e59;
  transform: translateY(0);
}

label {
  color: #374151;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.table {
  border-color: #e5e7eb;
}

.table tbody tr:hover {
  background-color: #f0fdfa;
}

.form-control:disabled {
  background-color: #f3f4f6;
  border-color: #d1d5db;
}
</style>
