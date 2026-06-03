<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>



    <div
        class=""
    >
        <div>
            <Link href="/" class="d-flex">

                <ApplicationLogo class="mt-2" style="width: 130px; height: 60px;"  />

            </Link>
        </div>

        <div
            class=""
            style="overflow: hidden !important;"
        >
            <slot />
        </div>
    </div>

</template>
<style scoped>

</style>
