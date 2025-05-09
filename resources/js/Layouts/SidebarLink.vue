<template>
    <a
      :href="to"
      class="block px-4 py-2 rounded hover:bg-gray-700"
    >
      {{ label }}
    </a>
  </template>

  <script setup>
  defineProps({
    to: String,
    label: String
  });
  </script>
