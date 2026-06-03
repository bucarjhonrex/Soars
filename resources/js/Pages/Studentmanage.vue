<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import Studentmanage from './Studentmanagement/StudentManage.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
 <Head title="Studentmanage" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Student Management
            </h2>
        </template>

       <Studentmanage>

       </Studentmanage>
    </AdminAuthenticatedLayout>
</template>
