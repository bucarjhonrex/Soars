<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <body class="boad">



    <!-- Single screen container -->
    <div class="vh-100 d-flex align-items-center justify-content-center bg-gradient position-relative overflow-hidden">

        <!-- Animated background elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0;">
            <div class="floating-circle floating-circle-1"></div>
            <div class="floating-circle floating-circle-2"></div>
        </div>

        <img
            id="background"
            class="position-absolute opacity-10 d-none d-lg-block"
            style="left: -80px; top: 0; max-width: 877px; z-index: 0; pointer-events: none;"
            src="https://laravel.com/assets/img/welcome/background.svg"
            alt="background"
        />

        <!-- Main content container -->
        <div class="container position-relative" style="z-index: 1; max-width: 1200px;">
            <div class="row align-items-center g-0">

                <!-- Left side - Branding and Info -->
                <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0 px-4 px-lg-5">
                    <!-- Logo -->
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-4 logo-container">
                        <div class="logo-icon">
                            <svg class="text-white" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h1 class="logo-text ms-3 mb-0">SOARS</h1>
                    </div>

                    <!-- Welcome content -->
                    <div class="welcome-content">
                        <h2 class="display-5 fw-bold text-teal mb-3">Welcome Back</h2>
                        <p class="lead text-muted mb-4">Student Online Admission Registration System</p>
                        <p class="text-muted">Streamline your admission process with our secure platform</p>
                    </div>

                    <!-- Feature highlights -->
                    <div class="d-none d-lg-flex gap-4 mt-5 justify-content-start">
                        <div class="feature-badge">
                            <svg class="feature-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="ms-2">Fast & Easy</span>
                        </div>
                        <div class="feature-badge">
                            <svg class="feature-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="ms-2">Secure</span>
                        </div>
                    </div>
                </div>

                <!-- Right side - Login card -->
                <div class="col-lg-6 px-4 px-lg-5">
                    <div class="card login-card shadow-lg">
                        <div class="card-body p-4 p-md-5">

                            <!-- Navigation buttons -->
                         <!-- Navigation buttons -->
<nav v-if="canLogin" class="d-flex justify-content-center gap-2 mb-4">
    <template v-if="$page.props.auth.user">
        <Link
            :href="$page.props.auth.user.role === 'admin' ? route('adminDashboard') : route('dashboard')"
            class="btn btn-teal btn-sm d-flex align-items-center"
        >
            <span>Dashboard</span>
            <svg class="ms-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </Link>
    </template>

    <template v-else>
        <!-- Both buttons in same row -->
        <div class="d-flex gap-2 justify-content-center w-100 flex-wrap">

        </div>
    </template>
</nav>


                            <!-- Welcome icon -->
                            <div class="text-center mb-4">
                              <div class="welcome-icon-circle">
    <svg width="60" height="60" viewBox="0 0 100 100">
        <!-- Teal circle background -->
        <circle cx="50" cy="50" r="45" fill="#14b8a6" />

        <!-- White book icon -->
        <path
            d="M30 30 h18 a4 4 0 0 1 4 4 v32 a4 4 0 0 1 -4 4 h-18
               M70 30 h-18 a4 4 0 0 0 -4 4 v32 a4 4 0 0 0 4 4 h18"
            stroke="white"
            stroke-width="6"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</div>
                            </div>

                            <!-- Card title -->
                            <h3 class="text-center fw-bold mb-2 text-teal">Get Started</h3>
                            <p class="text-center text-muted mb-4">Please log in to continue your journey</p>

                            <!-- CTA Button (shown only when not logged in) -->
                            <div v-if="canLogin && !$page.props.auth.user" class="text-center">
                                <Link
                                    :href="route('register')"
                                    class="btn btn-teal btn-lg w-100 d-flex align-items-center justify-content-center"
                                >
                                    <span class="me-2">Get Started Now</span>
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </Link>
                                 <Link
                                 :href="route('login')"
                                class="btn btn-outline-teal btn-sm"
                              >
                                      Log In
                                   </Link>
                            </div>

                            <!-- Feature pills -->
                            <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
                                <span class="badge shadow bg-teal-light">24/7 Support</span>
                                <span class="badge shadow bg-teal-light">Encrypted</span>
                                <span class="badge shadow bg-teal-light">User-Friendly</span>
                            </div>

                            <!-- Footer text -->
                            <div class="text-center mt-4 pt-4 border-top">
                                <small class="text-muted">
                                    <span class="status-dot"></span>
                                    Powered by SOARS Technology
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</template>

<style scoped>
/* Bootstrap 5 color scheme - Teal and White */
:root {
    --teal-primary: #14b8a6;
    --teal-dark: #0f766e;
    --teal-light: #5eead4;
    --teal-lighter: #ccfbf1;
}
.boad{
    background: linear-gradient(135deg, #8fcce3 10%, #f0fdfa 50%, #00ffc8 100%);
}
/* Background gradient */
.bg-gradient {
    background: linear-gradient(135deg, #8fcce3 10%, #f0fdfa 50%, #00ffc8 100%);
}

/* Floating background circles */
.floating-circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    background: teal;
    opacity: 0.3;
    pointer-events: none;
}

.floating-circle-1 {
    width: 400px;
    height: 400px;
    background: teal;
    top: -100px;
    left: -100px;
    animation: float 8s ease-in-out infinite;
}

.floating-circle-2 {
    width: 300px;
    height: 300px;
    background: teal;
    bottom: -80px;
    right: -80px;
    animation: float-delayed 10s ease-in-out infinite;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-20px, -20px); }
}

@keyframes float-delayed {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(20px, 20px); }
}

@keyframes bounce-gentle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Logo styles */
.logo-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--teal-primary), var(--teal-dark));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);
    transition: transform 0.3s ease;
}

.logo-container:hover .logo-icon {
    transform: scale(1.05);
}

.logo-text {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--teal-dark), var(--teal-primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Welcome content */
.welcome-content {
    animation: fade-in 0.8s ease-out;
}

.text-teal {
    color: var(--teal-dark) !important;
}

/* Feature badges */
.feature-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    background: white;
    border-radius: 20px;
    font-size: 0.875rem;
    color: var(--teal-dark);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.feature-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.15);
}

.feature-icon {
    color: var(--teal-primary);
}

/* Login card */
.login-card {
    border: none;
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    animation: fade-in 1s ease-out;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(20, 184, 166, 0.15) !important;
}

/* Welcome icon circle */
.welcome-icon-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--teal-primary), var(--teal-dark));
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);
    animation: bounce-gentle 3s ease-in-out infinite;
}

/* Buttons */
.btn-teal {
    background: linear-gradient(135deg, var(--teal-primary), var(--teal-dark));
    border: none;
    color: rgb(0, 0, 0);
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-teal:hover {
    background: linear-gradient(135deg, var(--teal-dark), var(--teal-primary));
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(20, 184, 166, 0.3);
    color: rgb(0, 0, 0);
}

.btn-teal:active {
    transform: translateY(0);
}

.btn-link.text-teal:hover {
    color: var(--teal-primary) !important;
}

/* Badges */
.badge.bg-teal-light {
    background: var(--teal-lighter) !important;
    color: var(--teal-dark);
    padding: 6px 12px;
    font-weight: 500;
    border-radius: 8px;
}

/* Status dot */
.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: var(--teal-primary);
    border-radius: 50%;
    margin-right: 8px;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .logo-text {
        font-size: 2rem;
    }

    .welcome-content h2 {
        font-size: 1.75rem !important;
    }
}

/* Outline Teal button for Login */
.btn-outline-teal {
    background: transparent;
    color: var(--teal-dark);
    border: 2px solid var(--teal-dark);
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-teal:hover {
    background: var(--teal-dark);
    color: rgb(0, 0, 0);
    transform: translateY(-2px);
}


/* Smooth transitions for all elements */
* {
    transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
}
</style>
