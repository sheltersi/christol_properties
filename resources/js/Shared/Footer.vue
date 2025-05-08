<!-- resources/js/Shared/Footer.vue -->
<template>
    <footer class="bg-gray-900 text-white py-8 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Company Info -->
            <div>
                <div class="flex">
                    <img :src="Logo" alt="" class="h-12 w-12">
                    <h2 class="text-xl font-semibold mb-2 mt-2 ms-2">Christol Property</h2>
                </div>
                <p class="text-sm text-gray-400">
                    Empowering the web with modern Laravel + Vue.js solutions.
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-blue-400">Home</a></li>
                    <li><a href="/about" class="hover:text-blue-400">How it Works</a></li>
                    <li><a href="/services" class="hover:text-blue-400">Apply to Rent</a></li>
                    <li><a href="/contact" class="hover:text-blue-400">Contact Us</a></li>
                    <li><a href="/contact" class="hover:text-blue-400">Available Cottages</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" aria-label="Twitter" class="hover:text-blue-400">
                        <i class="fab fa-twitter"></i>

                    </a>
                    <a href="#" aria-label="Facebook" class="hover:text-blue-400">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="hover:text-blue-400">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-500 text-sm">
            © {{ new Date().getFullYear() }} Christol Property. All rights reserved.
        </div>
    </footer>
</template>

<script setup>
import Logo from "@/images/logo.png"
</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';
</style>
