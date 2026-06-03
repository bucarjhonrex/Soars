<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <!-- Redesigned Container with Teal & White Theme -->
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-50 via-white to-teal-100 px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Card Container -->
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
                    <!-- Header Section -->
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-8 py-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4 shadow-lg">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                        <p class="text-teal-100 text-sm">Please sign in to your account</p>
                    </div>

                    <!-- Form Section -->
                    <div class="px-8 py-8">
                        <!-- Status Message -->
                        <div v-if="status" class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-lg text-sm font-medium text-teal-700 animate-fade-in">
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Email Field -->
                            <div class="transform transition-all duration-200 focus-within:scale-[1.02]">
                                <InputLabel for="email" value="Email" class="text-gray-700 font-semibold mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="pl-10 block w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 transition-all duration-200"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                    />
                                </div>
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- Password Field -->
                            <div class="transform transition-all duration-200 focus-within:scale-[1.02]">
                                <InputLabel for="password" value="Password" class="text-gray-700 font-semibold mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="pl-10 block w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 transition-all duration-200"
                                        v-model="form.password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center group cursor-pointer">
                                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500" />
                                    <span class="ml-2 text-sm text-gray-600 group-hover:text-teal-600 transition-colors duration-200">Remember me</span>
                                </label>

                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm text-teal-600 hover:text-teal-700 font-medium transition-colors duration-200 hover:underline"
                                >
                                    Forgot password?
                                </Link>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <PrimaryButton
                                    class="w-full justify-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-[1.02] hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span v-if="!form.processing">Log in</span>
                                    <span v-else class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <!-- Footer Decoration -->
                    <div class="h-2 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600"></div>
                </div>

                <!-- Additional Info -->
                <p class="mt-6 text-center text-sm text-gray-600">
                    Secured with industry-standard encryption
                </p>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
