<script setup>

import{ref, onMounted} from 'vue';
import{useForm} from '@inertiajs/vue3';

const educationInfo = ref([]);

const form= useForm({
    elementary_school_name: '',
    elementary_address:'',
    elementary_year_graduated:'',
    elementary_honors:'',

    junoir_school_name:'',
    junoir_address:'',
    junoir_year_graduated:'',
    junoir_honors:'',

    senior_school_name:'',
    senior_address:'',
    senior_year_graduated:'',
    senior_honors:'',

    college_school_name:'',
    college_address:'',
    college_year_graduated:'',
    college_honors:'',

});

    const fetchStudents = async()=>{
            const res = await axios.get('/getIded');
    students.value = res.data;

    const student = students.value.find(s => s.user.id === user.id);

        student.education_info?.forEach(educ => {
            if(educ.level === "elementary"){
                form.elementary_school_name = educ.school_name;
                form.elementary_address = educ.address;
                form.elementary_year_graduated =educ.year_graduated;
                form.elementary_honors = educ.honors;
            }
            if(educ.level === "junoir"){
                form.junoir_school_name === educ.school_name;
                form.junoir_address === educ.address;
                form.junoir_year_graduated  === educ.year_graduated;
                form.junoir_honors === educ.honors;
            }
            if(educ.level === "senior"){
                form.senior_school_name === educ.school_name;
                form.senior_address === educ.address;
                form.senior_year_graduated === educ.year_graduated;
                form.senior_honors === educ.honors;
            }
            if(educ.level === "college"){
                form.college_school_name === educ.school_name;
                form.college_address === educ.address;
                form.college_year_graduated === educ.year_graduated;
                form.college_honors === educ.honors;
            }
        });
    };

    const submitEducation = () => {
    form.post(route("submit.education"), {
        onSuccess: () => {
            alert("Education submitted successfully!");
        }
    });
};

</script>
<template>
    <section>
        <form action="" @submit.prevent="submitEducation">
              <h5 class="text-success mb-3">Educational Background</h5>
          <table class="table ">
            <tbody>
            <tr>
                <th>Level</th>
                <th>School Name</th>
                <th>Address</th>
                <th>Year Graduated</th>
                <th>Honors</th>
            </tr>
            <tr>
                <td>Elementary</td>
                <td>
                    <input v-model="form.elementary_school_name" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.elementary_address" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.elementary_year_graduated" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.elementary_honors" type="text" class="form-control">
                </td>
            </tr>
            <tr>
                <td>Junior High</td>
                <td>
                    <input v-model="form.junoir_school_name" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.junoir_address" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.junoir_year_graduated" type="text" class="form-control">
                </td>
                 <td>
                    <input v-model="form.junoir_honors" type="text" class="form-control">
                </td>
            </tr>
            <tr>
                <td>Senior High</td>
                <td>
                    <input v-model="form.senior_school_name" type="text" class="form-control"></td>
                    <td>
                        <input v-model="form.senior_address" type="text" class="form-control">
                    </td>
                    <td>
                        <input v-model="form.senior_year_graduated" type="text" class="form-control">
                    </td>
                     <td>
                    <input v-model="form.senior_honors" type="text" class="form-control">
                </td>
                </tr>
            <tr>
                <td>College</td>
                <td>
                    <input v-model="form.college_school_name" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.college_address" type="text" class="form-control">
                </td>
                <td>
                    <input v-model="form.college_year_graduated" type="text" class="form-control">
                </td>
                 <td>
                    <input v-model="form.college_honors" type="text" class="form-control">
                </td>
            </tr>
            </tbody>
          </table>
          </form>
    </section>
</template>
