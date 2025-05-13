<template>
    <a
      :href="to"
      :method="method"
      :as="as"
      class="block px-4 py-2 rounded hover:bg-gray-700"
    >
      {{ label }}
    </a>
  </template>

  <script setup>
  defineProps({
    to: String,
    label: String,
    method:{
        type:String,
        default:'get'
    },
    as:{
        type:String,
        default:'a'
    }
  });
  </script>
