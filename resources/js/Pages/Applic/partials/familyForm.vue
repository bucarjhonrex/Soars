<script setup>
 import{ref, onMounted} from 'vue';
import{useForm} from '@inertiajs/vue3';

const familyInfo=ref([]);

const form = useForm({
    father_fname:'',
    father_lname:'',
    father_mname:'',
    father_suffix:'',
    father_contact_no:'',
    father_email:'',
    father_occupation:'',
    father_livstatus:'',

    mother_fname:'',
    mother_lname:'',
    mother_mname:'',
    mother_suffix:'',
    mother_contact_no:'',
    mother_email:'',
    mother_occupation:'',
    mother_livstatus:'',

    guardian_fname:'',
    guardian_lname:'',
    guardian_mname:'',
    guardian_suffix:'',
    guardian_contact_no:'',
    guardian_email:'',
    guardian_occupation:'',
    guardian_livstatus:'',
});

const fetchStudents =async()=>{
    const res = await axios.get('/getFam');
    StudentManage.value = res.data;

     const student = students.value.find(s => s.user.id === user.id);

     student.family_info?.forEach(fam => {
        if(fam.family_member === "father"){
            form.father_fname  = fam.fname;
            form.father_lname   = fam.lname;
            form.father_mname   = fam.mname;
            form.father_suffix = fam.suffix;
            form.father_contact_no = fam.contact_no;
            form.father_email = fam.email;
            form.father_occupation =fam.occupation;
            form.father_livstatus = fam.livstatus;
        }
        if(fam.family_member === "mother"){
            form.mother_fname  = fam.fname;
            form.mother_lname   = fam.lname;
            form.mother_mname   = fam.mname;
            form.mother_suffix = fam.suffix;
            form.mother_contact_no = fam.contact_no;
            form.mother_email = fam.email;
            form.mother_occupation =fam.occupation;
            form.mother_livstatus = fam.livstatus;
        }
        if(fam.family_member === "guardian"){
             form.guardian_fname  = fam.fname;
            form.guardian_lname   = fam.lname;
            form.guardian_mname   = fam.mname;
            form.guardian_suffix = fam.suffix;
            form.guardian_contact_no = fam.contact_no;
            form.guardian_email = fam.email;
            form.guardian_occupation =fam.occupation;
            form.guardian_livstatus = fam.livstatus;
        }
     });

};

 const submitEducation = () => {
    form.post(route("submit.family"), {
        onSuccess: () => {
            alert("Education submitted successfully!");
        }
    });
};

</script>
<template>
    <section>
         <h5 class="text-success mb-3">Family Information</h5>
          <table class="table align-middle">
            <tbody>
            <tr>
              <td>
                <label for="">Father's Name</label>
                <input type="text" class="form-control" placeholder="First Name">
              </td>
              <td>
                <label for=""></label>
                <input type="text" class="form-control" placeholder="Middle Name">
                </td>
                <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Last Name">
                </td> <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Suffix">
              </td>
            </tr>
            <tr>
              <td><label for="">Occupation</label><input type="text" class="form-control"></td>
              <td><label for="">Contact No.</label><input type="text" class="form-control"></td>
              <td><label for="">Email</label><input type="email" class="form-control"></td>
              <td><label for="">Living Status</label>
                <select name="" id="" class="form-select">
                  <option value="">Alive</option>
                  <option value="">Deceased</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Mother's Name</label>
                <input type="text" class="form-control" placeholder="First Name">
              </td>
              <td>
                <label for=""></label>
                <input type="text" class="form-control" placeholder="Middle Name">
                </td>
                <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Last Name">
                </td> <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Suffix">
              </td>
            </tr>
            <tr>
              <td><label for="">Occupation</label><input type="text" class="form-control"></td>
              <td><label for="">Contact No.</label><input type="text" class="form-control"></td>
              <td><label for="">Email</label><input type="email" class="form-control"></td>
              <td><label for="">Living Status</label>
                <select name="" id="" class="form-select">
                  <option value="">Alive</option>
                  <option value="">Deceased</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Guardian's Name</label>
                <input type="text" class="form-control" placeholder="First Name">
              </td>
              <td>
                <label for=""></label>
                <input type="text" class="form-control" placeholder="Middle Name">
                </td>
                <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Last Name">
                </td> <td>
                  <label for=""></label>
                <input type="text" class="form-control" placeholder="Suffix">
              </td>
            </tr>
            <tr>
              <td><label for="">Occupation</label><input type="text" class="form-control"></td>
              <td><label for="">Contact No.</label><input type="text" class="form-control"></td>
              <td><label for="">Email</label><input type="email" class="form-control"></td>
              <td></td>
            </tr>
            </tbody>
          </table>
    </section>
</template>
