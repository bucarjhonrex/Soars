<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MainLayout from './Applic/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
 <Head title="Application" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Application
            </h2>
        </template>

      <MainLayout>
        
      </MainLayout>
    </AuthenticatedLayout>
</template>
