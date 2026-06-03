<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingMobileNav = ref(false);
</script>

<template>
    <div class="layout-container">
        <!-- Sidebar (Desktop) -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <Link :href="$page.props.auth.user.role === 'admin' ? route('adminDashboard') : route('dashboard')">
                    <ApplicationLogo class="logo-image" />
                </Link>
            </div>

            <nav class="sidebar-nav">
                <NavLink
                    :href="$page.props.auth.user.role === 'admin' ? route('adminHome'): route('Home')"
                    :active="route().current($page.props.auth.user.role === 'admin' ? 'adminHome' : 'Home')"
                    class="nav-item">
                    <i class="fas fa-home nav-icon"></i>
                    Home
                </NavLink>

                <NavLink
                    :href="$page.props.auth.user.role === 'admin' ? route('adminDashboard') : route('dashboard')"
                    :active="route().current($page.props.auth.user.role === 'admin' ? 'adminDashboard' : 'dashboard')"
                    class="nav-item">
                    <i class="fas fa-chart-line nav-icon"></i>
                    Dashboard
                </NavLink>

                <NavLink
                    :href="$page.props.auth.user.role === 'admin' ? route('Studentmanage'): route('')"
                    :active="route().current($page.props.auth.user.role === 'admin' ? 'Studentmanage' : '')"
                    class="nav-item">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    Student Management
                </NavLink>

                <NavLink
                    :href="$page.props.auth.user.role === 'admin' ? route('Calendar'): route('')"
                    :active="route().current($page.props.auth.user.role === 'admin' ? 'Calendar' : '')"
                    class="nav-item">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                    Exam Management
                </NavLink>

                <NavLink
                    :href="$page.props.auth.user.role === 'admin' ? route('CourseManage'): route('')"
                    :active="route().current($page.props.auth.user.role === 'admin' ? 'CourseManage' : '')"
                    class="nav-item">
                    <i class="fas fa-book nav-icon"></i>
                    Course Management
                </NavLink>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="main-wrapper">
            <!-- Top Navigation -->
            <div class="top-navbar">
                <!-- Mobile Hamburger -->
                <button
                    @click="showingMobileNav = !showingMobileNav"
                    class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- User Dropdown -->
                <div class="user-dropdown-wrapper">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="user-trigger-btn">
                                <i class="fas fa-user-circle user-icon"></i>
                                {{ $page.props.auth.user.lname }}
                                <svg class="chevron-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                <i class="fas fa-user-edit"></i> Profile
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                <i class="fas fa-sign-out-alt"></i> Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div v-show="showingMobileNav" class="mobile-nav">
                <nav class="mobile-nav-content">
                    <ResponsiveNavLink
                        :href="$page.props.auth.user.role === 'admin' ? route('adminDashboard') : route('dashboard')"
                        :active="route().current($page.props.auth.user.role === 'admin' ? 'adminDashboard' : 'dashboard')">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')">
                        <i class="fas fa-user-edit"></i> Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </ResponsiveNavLink>
                </nav>
            </div>

            <!-- Page Heading -->
            <header class="page-header" v-if="$slots.header">
                <div class="header-content">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

.layout-container {
    display: flex;
    min-height: 100vh;
    background-color: #f5f7fa;
}

/* Sidebar Styles */
.sidebar {
    width: 280px;
    background: white;
    border-right: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
}

.sidebar-logo {
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
}

.logo-image {
    height: 40px;
    width: auto;
    fill: #14b8a6;
}

.sidebar-nav {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 0 16px 32px;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    font-size: 14px;
    font-weight: 500;
    color: #4b5563;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.nav-item:hover {
    background-color: #f0fdfa;
    color: #14b8a6;
}

.nav-item[data-active="true"] {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.nav-icon {
    margin-right: 12px;
    font-size: 16px;
}

/* Main Wrapper */
.main-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Top Navbar */
.top-navbar {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    height: 64px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.mobile-menu-btn {
    display: none;
    padding: 8px;
    background: transparent;
    border: none;
    color: #6b7280;
    font-size: 20px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.2s;
}

.mobile-menu-btn:hover {
    background-color: #f0fdfa;
    color: #14b8a6;
}

.user-dropdown-wrapper {
    margin-left: auto;
}

.user-trigger-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    color: #4b5563;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.user-trigger-btn:hover {
    background-color: #f0fdfa;
    border-color: #14b8a6;
    color: #14b8a6;
}

.user-icon {
    margin-right: 8px;
    font-size: 18px;
}

.chevron-icon {
    margin-left: 8px;
    width: 16px;
    height: 16px;
}

/* Mobile Nav */
.mobile-nav {
    display: none;
    background: white;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.mobile-nav-content {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Page Header */
.page-header {
    background: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.header-content {
    max-width: 1280px;
    margin: 0 auto;
    padding: 20px 24px;
}

/* Page Content */
.page-content {
    flex: 1;
    padding: 24px;
    background-color: #f5f7fa;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .sidebar {
        display: none;
    }

    .mobile-menu-btn {
        display: block;
    }

    .mobile-nav {
        display: block;
    }
}
</style>
