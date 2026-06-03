<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    fname: '',
    lname:'',
    mname:'',
    phone_number:'',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <body class="boda">


        <Head title="Register" />


        <form @submit.prevent="submit" class="register-form">
            <div class="form-group">
                <InputLabel for="fname" value="First Name" />
                <TextInput
                    id="fname"
                    type="text"
                    class="mt-1 block w-full form-input"
                    v-model="form.fname"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.fname" />
            </div>

            <div class="form-group">
                <InputLabel for="lname" value="Last Name" />
                <TextInput
                    id="lname"
                    type="text"
                    class="mt-1 block w-full form-input"
                    v-model="form.lname"
                    required
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.lname" />
            </div>

            <div class="form-group">
                <InputLabel for="mname" value="Middle name" />
                <TextInput
                    id="mname"
                    type="text"
                    class="mt-1 block w-full form-input"
                    v-model="form.mname"
                    required
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.mname" />
            </div>

            <div class="form-group">
                <InputLabel for="phone_number" value="Phone Number" />
                <TextInput
                    id="phone_number"
                    type="text"
                    class="mt-1 block w-full form-input"
                    v-model="form.phone_number"
                    required
                    autocomplete="number"
                />
                <InputError class="mt-2" :message="form.errors.phone_number" />
            </div>

            <div class="form-group">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full form-input"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="form-group">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full form-input"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="form-group">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full form-input"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="form-actions">
                <Link
                    :href="route('login')"
                    class="login-link"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="register-button"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
        </body>
    </GuestLayout>

</template>

<style scoped>
    .boda{
            .boad{
    background: linear-gradient(135deg, #8fcce3 10%, #f0fdfa 50%, #00ffc8 100%);
}
    }
.register-form {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group:last-of-type {
    margin-bottom: 2rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.form-input:hover {
    border-color: #99f6e4;
}

.form-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 2rem;
}

.login-link {
    color: #0f766e;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.3s ease;
    padding: 0.5rem;
    border-radius: 4px;
}

.login-link:hover {
    color: #14b8a6;
    text-decoration: underline;
}

.login-link:focus {
    outline: 2px solid #14b8a6;
    outline-offset: 2px;
}

.register-button {
    background: #14b8a6;
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px;
}

.register-button:hover:not(:disabled) {
    background: #0f766e;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.register-button:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(20, 184, 166, 0.3);
}

.register-button:disabled {
    cursor: not-allowed;
    background: #99f6e4;
}

.register-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.3);
}

.opacity-25 {
    opacity: 0.25;
}

/* Additional styling for labels */
.register-form label {
    display: block;
    margin-bottom: 0.5rem;
    color: #374151;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Spacing utilities preserved */
.mt-1 {
    margin-top: 0.25rem;
}

.mt-2 {
    margin-top: 0.5rem;
}

.mt-4 {
    margin-top: 1rem;
}

.block {
    display: block;
}

.w-full {
    width: 100%;
}
</style>
