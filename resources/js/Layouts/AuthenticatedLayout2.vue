<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/images/logo.png';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const sidebarOpen = ref(false);
const isMobile = ref(false);

onMounted(() => {
  // This runs only in the browser
  const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
  };

  checkMobile();
  window.addEventListener('resize', checkMobile);

  // Cleanup on unmount
  onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
  });
});
</script>


<style scoped>
.sidebar-link {
  @apply block px-4 py-2 text-gray-700 rounded hover:bg-gray-200 transition;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
</style>


<template>
    <div class="flex min-h-screen bg-gray-100">
      <!-- Sidebar -->
      <transition name="slide">
  <aside
    v-show="sidebarOpen || !isMobile"
    class="fixed md:static z-50 inset-y-0 left-0 w-64 bg-white shadow-md transform transition-transform duration-200 ease-in-out"
    :class="{
      '-translate-x-full': isMobile && !sidebarOpen,
      'translate-x-0': sidebarOpen || !isMobile
    }"
  >

          <!-- Mobile close button -->
          <div class="flex items-center justify-between p-4 border-b md:hidden">
            <div class="font-bold text-xl">Christol Dashboard</div>
            <button @click="sidebarOpen = false" class="text-gray-500">
              ✕
            </button>
          </div>
          <div class="hidden md:block p-6 font-bold text-xl border-b">
            Christol Dashboard
          </div>
          <nav class="p-4 space-y-2">
            <Link href="/appointments" class="sidebar-link">Book Appointment</Link>
            <Link href="/apply-to-rent" class="sidebar-link">Apply to Rent</Link>
            <Link href="/applications" class="sidebar-link">View Applications</Link>
            <Link href="/profile" class="sidebar-link">Profile Settings</Link>
            <Link :href="route('logout')" method="post" as="button" class="sidebar-link text-red-600">
              Logout
            </Link>
          </nav>
        </aside>
      </transition>

      <!-- Main content -->
      <div class="flex-1 flex flex-col w-full">
        <!-- Top Navbar -->
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
          <!-- Mobile Menu Button -->
          <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <!-- Optional Page Title -->
          <slot name="header" />
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
          <slot />
        </main>
      </div>
    </div>
  </template>
