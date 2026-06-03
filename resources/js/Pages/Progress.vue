<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Progress" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admission Progress
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

                <!-- PROGRESS BAR SECTION -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">

                    <h4 class="mb-3 text-lg font-bold text-gray-700">Your Admission Steps</h4>

                    <!-- Progress Bar -->
                    <div class="progress" style="height: 25px;">
                        <div
                            class="progress-bar progress-bar-striped"
                            role="progressbar"
                            style="width: 40%;"  <!-- Just UI placeholder -->
                        >
                            40% Complete
                        </div>
                    </div>
                </div>

                <!-- STEP LIST -->
                <div class="bg-white shadow-sm rounded-lg p-6">

                    <h4 class="mb-4 text-lg font-semibold text-gray-700">
                        Steps Overview
                    </h4>

                    <div class="list-group">

                        <!-- STEP 1 -->
                        <div class="list-group-item py-3">
                            <h5 class="fw-bold">1. Submit Online Application</h5>
                            <p class="text-muted mb-0">
                                You have submitted your application. Please wait for verification.
                            </p>
                        </div>

                        <!-- STEP 2 -->
                        <div class="list-group-item py-3">
                            <h5 class="fw-bold">2. Submit Physical Requirements</h5>
                            <p class="text-muted mb-0">
                                Bring your documents (Form 137, PSA Birth Certificate, ID Pictures, etc.) to the registrar.
                            </p>
                        </div>

                        <!-- STEP 3 -->
                        <div class="list-group-item py-3">
                            <h5 class="fw-bold">3. Proceed to Examination</h5>
                            <p class="text-muted mb-0">
                                Once cleared, you may proceed to take the entrance exam.
                            </p>
                        </div>

                        <!-- STEP 4 -->
                        <div class="list-group-item py-3">
                            <h5 class="fw-bold">4. Interview (If Required)</h5>
                            <p class="text-muted mb-0">
                                Some courses require a short interview with the program head.
                            </p>
                        </div>

                        <!-- STEP 5 -->
                        <div class="list-group-item py-3">
                            <h5 class="fw-bold">5. Final Admission</h5>
                            <p class="text-muted mb-0">
                                Receive confirmation of acceptance and proceed to enrollment.
                            </p>
                        </div>

                    </div>

                    <!-- NEXT STEP SECTION -->
                    <div class="alert alert-info mt-4">
                        <strong>Next Step:</strong> Please submit your physical requirements to continue.
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
