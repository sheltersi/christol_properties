<script setup>
import ApplicationLogo from '@/images/logo.png';
import { Link } from '@inertiajs/vue3';
</script>

<template>
     <div class="bg-linear-to-r from-cyan-800 via-cyan-700 to-cyan-500 ">
    <div
        class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0  mx-3 sm:m-0">

            <div>
                <Link href="/">
                <!-- <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" /> -->
                <img :src="ApplicationLogo" class="h-20 w-20 fill-current" alt="">
                </Link>
            </div>

            <div class="mt-6 w-full overflow-hidden bg-white  shadow-md sm:max-w-md sm:rounded-lg">
                <slot />
            </div>
        </div>
    </div>
</template>
