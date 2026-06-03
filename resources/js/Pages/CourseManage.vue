<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import Course from './Course/Course.vue';
import assignCourse from './Course/assignCourse.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
     <Head title="Course Management" />
    <AdminAuthenticatedLayout>
        <div class="container">
            <Course/>
        </div>
        <div class="container mt-4">
           
        </div>
    </AdminAuthenticatedLayout>
</template>
