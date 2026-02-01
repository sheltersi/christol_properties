<template>
    <div class="relative inline-block text-left">
      <button
        @click="toggleDropdown"
        class="px-3 py-1 text-sm bg-gray-200 hover:bg-gray-300 rounded-sm"
      >
        Actions
      </button>

      <div
        v-if="isOpen"
        class="absolute right-0 z-10 mt-2 w-40 bg-white border rounded-sm shadow-lg"
      >
        <slot />
      </div>
    </div>
  </template>

  <script setup>
  import { onClickOutside } from '@vueuse/core';
  import {ref} from 'vue'

  const isOpen = ref(false);
  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };

  // Close dropdown if clicked outside
  const dropdown = ref(null);
  onClickOutside(dropdown, () => {
    isOpen.value = false;
  });
  </script>

  <style scoped>
  </style>
