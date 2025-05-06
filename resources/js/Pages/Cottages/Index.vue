<template>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-8">Available Cottages</h1>

      <div v-if="cottages.length" class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="cottage in cottages"
          :key="cottage.id"
          class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition"
        >
          <img
            :src="cottage.image_url || placeholder"
            alt="Cottage Image"
            class="w-full h-48 object-cover"
          />
          <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ cottage.name }}</h2>
            <p class="text-gray-600 mt-1">{{ cottage.location }}</p>
            <p class="text-blue-600 font-bold mt-2">R{{ cottage.price_per_month }}/month</p>
            <p class="text-sm text-green-600 mt-1" v-if="cottage.is_available">Available</p>
            <p class="text-sm text-red-600 mt-1" v-else>Currently Rented</p>
          </div>
        </div>
      </div>

      <div v-else class="text-gray-600 text-center mt-12">
        No cottages available at the moment.
      </div>
    </div>
  </template>

  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'

  defineOptions({layout: AppLayout})

  defineProps({cottages: Array})

  const placeholder = 'https://via.placeholder.com/600x400?text=No+Image'
  </script>
