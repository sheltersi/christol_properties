<template>
    <div>
      <nav class="bg-white border-b shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
              <Link href="/" class="flex items-center space-x-2 text-gray-800 font-bold text-xl">
                <img :src="Logo" alt="Christol Property logo" class="h-10 w-auto" />
                <span>Christol Property</span>
              </Link>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
              <Link href="/" class="nav-link">Home</Link>
              <Link href="/how-it-works" class="nav-link">How it Works</Link>
              <Link href="{{ route('application.create') }}" class="nav-link">Apply to Rent</Link>
              <Link href="/contact" class="nav-link">Contact Us</Link>
              <Link href="/cottages" class="nav-link">Available Cottages</Link>

            </div>

            <!-- Login/Register -->
            <div class="hidden md:flex items-center space-x-4">
              <Link href="/login" class="text-sm text-gray-600 hover:text-gray-800 font-medium">
                Login
              </Link>
              <Link href="/register" class="text-sm text-gray-600 hover:text-gray-800 font-medium">
               Register
              </Link>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
              <button @click="isOpen = !isOpen" class="text-gray-800 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <path v-if="!isOpen" d="M4 6h16M4 12h16M4 18h16" />
                  <path v-else d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isOpen" class="md:hidden bg-white shadow-md">
          <div class="px-4 py-3 space-y-2">
            <Link href="/" class="block nav-link">Home</Link>
            <Link href="{{ route('cottages.index') }}" class="block nav-link">Available Cottages</Link>
            <Link href="/how-it-works" class="block nav-link">How it Works</Link>
            <Link href="{{ route('application.create') }}" class="block nav-link">Apply to Rent</Link>
            <Link href="/contact" class="block nav-link">Contact Us</Link>
            <Link :href="route('login')" class="block text-sm text-gray-600 hover:text-gray-800 font-medium pt-2">
              Login
            </Link>
            <Link :href="route('register')" class="block text-sm text-gray-600 hover:text-gray-800 font-medium pt-2">
              Register
            </Link>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="">
        <slot />
      </main>
      <Footer />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Link } from '@inertiajs/vue3'
  import Logo from '@/images/logo.png'
  import Footer from '@/Shared/Footer.vue'

  const isOpen = ref(false);

  defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

  </script>

  <style scoped>
  .nav-link {
    @apply text-gray-700 hover:font-bold hover:text-blue-500 px-3 py-2 text-sm font-medium;
  }
  </style>
