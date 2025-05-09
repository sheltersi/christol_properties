<template>
    <div>
      <!-- Desktop Sidebar -->
      <aside class="hidden lg:block w-64 bg-gray-900 text-white h-screen fixed">
        <nav class="mt-10">
          <SidebarLink label="Dashboard" to="/dashboard" />
          <SidebarLink label="Viewings" to="/appointments" />
          <SidebarLink label="Apply to Rent" to="/apply-to-rent" />
          <SidebarLink label="Documents" to="/documents" />
        </nav>
      </aside>

      <!-- Mobile Menu Button -->
      <button
        @click="drawerOpen = true"
        class="lg:hidden fixed top-4 left-4 z-50 bg-gray-800 text-white p-2 rounded"
      >
        <MenuIcon />
      </button>

      <!-- Mobile Drawer -->
      <Transition name="fade">
        <div
          v-if="drawerOpen"
          class="fixed inset-0 z-40 bg-black bg-opacity-50"
          @click.self="drawerOpen = false"
        >
          <aside
            class="w-64 bg-gray-900 text-white h-full p-4 shadow-lg z-50"
            @click.stop
          >
            <button
              class="text-right text-white mb-4"
              @click="drawerOpen = false"
            >
              ✖
            </button>
            <nav>
              <SidebarLink label="Dashboard" to="/dashboard" />
              <SidebarLink label="Viewings" to="/appointments" />
              <SidebarLink label="Apply to Rent" to="/apply-to-rent" />
              <SidebarLink label="Documents" to="/documents" />
            </nav>
          </aside>
        </div>
      </Transition>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import SidebarLink from './SidebarLink.vue';
  import { MenuIcon } from 'lucide-vue-next';

  const drawerOpen = ref(false);
  </script>

  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
