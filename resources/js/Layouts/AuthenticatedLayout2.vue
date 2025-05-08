<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/images/logo.png';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
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


<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <transition name="slide">
      <!-- <aside
        v-show="sidebarOpen"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-md transform md:static md:translate-x-0 transition-transform duration-200 ease-in-out"
      > -->
      <aside
    v-show="sidebarOpen || !isMobile"
    class="fixed md:static z-50 inset-y-0 left-0 w-64 bg-white shadow-md transform transition-transform duration-200 ease-in-out"
    :class="{
      '-translate-x-full': isMobile && !sidebarOpen,
      'translate-x-0': sidebarOpen || !isMobile
    }"
  >  <!-- Mobile close button -->
          <div class="flex items-center justify-between p-4 border-b md:hidden">
            <div class="font-bold text-xl">Christol Dashboard</div>
            <button @click="sidebarOpen = false" class="text-gray-500">
              ✕
            </button>
          </div>
         <div class="p-4 font-bold text-xl border-b">Christol Dashboard</div>
        <nav class="p-4 space-y-2">
          <Link href="/appointments" class="sidebar-link">Book Appointment</Link>
          <Link href="/apply-to-rent" class="sidebar-link">Apply to Rent</Link>
          <Link href="/applications" class="sidebar-link">View Applications</Link>
          <Link href="/profile" class="sidebar-link">Profile Settings</Link>
          <Link :href="route('logout')" method="post" as="button" class="sidebar-link text-red-600">Logout</Link>
        </nav>
      </aside>
    </transition>

    <!-- Main content -->
    <div class="flex flex-col w-full">
      <!-- Top Nav -->
      <nav class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 shadow">
        <div class="flex h-16 justify-between items-center">
          <div class="flex items-center">
            <!-- Mobile sidebar toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 text-gray-700 focus:outline-none">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
            <Link :href="route('dashboard')">
              <img :src="ApplicationLogo" alt="Logo" class="block h-9 w-auto" />
            </Link>
          </div>

          <div class="hidden sm:flex items-center space-x-6">
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Book Appointment</NavLink>

            <!-- User Dropdown -->
            <Dropdown align="right" width="48">
              <template #trigger>
                <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                  {{ $page.props.auth.user.first_name }}
                  <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586..." clip-rule="evenodd" />
                  </svg>
                </button>
              </template>
              <template #content>
                <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
              </template>
            </Dropdown>
          </div>

          <!-- Hamburger for mobile dropdown -->
          <div class="sm:hidden">
            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="p-2 text-gray-400 hover:text-gray-500">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                <path
                  :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Responsive Menu -->
        <div v-show="showingNavigationDropdown" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</ResponsiveNavLink>
          </div>
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 text-base text-gray-800">{{ $page.props.auth.user.first_name }}</div>
            <div class="px-4 text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Header Slot -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

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
