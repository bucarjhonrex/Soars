<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

// form state
const form = useForm({
    student_id: 1, // replace dynamically if needed
    form137: null,
    birth_certificate: null,
    good_moral: null,
    medical_form: null,
    id_picture: null,
});

// handle file input
const handleFileChange = (event, field) => {
    const target = event.target;
    if (target.files && target.files[0]) {
        form[field] = target.files[0];
    }
};

// submit documents
const submitDocuments = () => {
    const data = new FormData();
    // convert number to string to avoid errors
    data.append('student_id', form.student_id.toString());

    if (form.form137) data.append('form137', form.form137);
    if (form.birth_certificate) data.append('birth_certificate', form.birth_certificate);
    if (form.good_moral) data.append('good_moral', form.good_moral);
    if (form.medical_form) data.append('medical_form', form.medical_form);
    if (form.id_picture) data.append('id_picture', form.id_picture);

    fetch('/documents/store', {
        method: 'POST',
        body: data,
    })
    .then(res => res.json())
    .then(res => console.log(res))
    .catch(err => console.error(err));
};
</script>

<template>
<section>
    <h5 class="text-success mb-3">Upload Documents</h5>
    <table class="table">
        <tbody>
            <tr>
                <td>Form 137 / TOR</td>
                <td><input type="file" class="form-control" @change="e => handleFileChange(e, 'form137')"></td>
            </tr>
            <tr>
                <td>Birth Certificate</td>
                <td><input type="file" class="form-control" @change="e => handleFileChange(e, 'birth_certificate')"></td>
            </tr>
            <tr>
                <td>Good Moral Certificate</td>
                <td><input type="file" class="form-control" @change="e => handleFileChange(e, 'good_moral')"></td>
            </tr>
            <tr>
                <td>Medical Form</td>
                <td><input type="file" class="form-control" @change="e => handleFileChange(e, 'medical_form')"></td>
            </tr>
            <tr>
                <td>ID Picture (2x2)</td>
                <td><input type="file" class="form-control" @change="e => handleFileChange(e, 'id_picture')"></td>
            </tr>
        </tbody>
    </table>

    <button class="btn btn-success" @click="submitDocuments">Upload</button>
</section>
</template>
