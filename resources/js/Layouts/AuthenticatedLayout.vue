<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ApplicationLogo from '@/images/logo.png';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import SidebarLink from './SidebarLink.vue';
import { MenuIcon, XIcon } from 'lucide-vue-next';

const drawerOpen = ref(false);
</script>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Mobile Sidebar Drawer -->
    <transition name="fade">
      <div
        v-if="drawerOpen"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        @click="drawerOpen = false"
      ></div>
    </transition>
    <aside
      class="fixed top-0 left-0 z-50 h-full w-64 bg-white border-r shadow-lg transform lg:translate-x-0 transition-transform duration-300 ease-in-out"
      :class="{ '-translate-x-full': !drawerOpen }"
    >
      <div class="flex items-center justify-between p-4 border-b">
        <img :src="ApplicationLogo" alt="Logo" class="h-8" />
        <button class="lg:hidden" @click="drawerOpen = false">
          <XIcon class="h-6 w-6" />
        </button>
      </div>
      <nav class="mt-4 space-y-2 px-4">
        <SidebarLink :to="route('dashboard')" label="Book Appointment" />
        <SidebarLink :to="route('rent.create')" label="Apply to rent" />
      </nav>
    </aside>

    <!-- Main content -->
    <div class="flex flex-col flex-1 lg:ml-64">
      <!-- Topbar -->
      <nav class="bg-white border-b shadow sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center space-x-4">
            <button class="lg:hidden" @click="drawerOpen = true">
              <MenuIcon class="h-6 w-6 text-gray-700" />
            </button>
            <Link :href="route('dashboard')">
              <img :src="ApplicationLogo" alt="Logo" class="h-9 w-auto" />
            </Link>
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Book Appointment</NavLink>
            <NavLink :href="route('rent.create')" :active="route().current('rent.create')">
              Apply to rent
            </NavLink>
          </div>

          <!-- User Dropdown -->
          <Dropdown :align="right" width="48">
            <template #trigger>
              <button class="user-cicle inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
                <font-awesome-icon :icon="['fas', 'user']" class="mr-2 text-gray-500" />
                {{ $page.props.auth.user?.first_name }}
                <font-awesome-icon :icon="['fas', 'angle-down']" class="ms-2" />
              </button>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
            </template>
          </Dropdown>
        </div>
      </nav>

      <!-- Header Slot -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-6">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main class="">
        <div class="">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<style scoped>
.sidebar-link {
  @apply block px-4 py-2 rounded text-gray-700 hover:bg-gray-200 transition;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
