<template>
    <section class="relative bg-cover bg-center bg-no-repeat min-h-screen flex items-center justify-center text-white"
             :style="{backgroundImage:`url(${houseImage})`}">
      <!-- Dark Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-60"></div>

      <!-- Content -->
      <div class="relative z-10 max-w-4xl text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
          Find Your Perfect Home
        </h1>
        <p class="text-lg md:text-xl mb-8">
          Kristo Properties connects you with peaceful, long-term house/cottage rentals designed for comfortable living.
        </p>
        <Link
          href="/apply-to-rent/create"
          class="inline-block btn-bg text-white font-semibold py-3 px-6 rounded-lg transition"
        >
          Get Started
        </Link>
      </div>
    </section>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3'
  import houseImage from '@/images/houses/house.jpg'
  </script>

  <style scoped>
.btn-bg{
    background-color: darkcyan;
}

.btn-bg:hover{
    background-color: rgb(5, 70, 70);
}
</style>
