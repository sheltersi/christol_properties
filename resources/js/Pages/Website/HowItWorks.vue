<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

const steps = [
  {
    title: "Browse Listings",
    description: "Explore properties in your desired location.",
  },
  {
    title: "Book a Viewing",
    description: "Pick a time that suits you to view the property.",
  },
  {
    title: "Submit Application",
    description: "Complete the rental application online.",
  },
  {
    title: "Get Approved",
    description: "We review your application within 1–2 days.",
  },
  {
    title: "Pay Deposit & Rent",
    description: "Make payment to secure your new home & upload the proof of payment online.",
  },
  {
    title: "Sign Lease & Move In",
    description: "Sign the lease and collect your keys.",
  },
];

</script>

<template>
<section class="bg-gray-50 py-12">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">How It Works</h2>
    <p class="text-gray-600 mb-12">
      Your journey to a new home is just a few steps away — simple, guided, and transparent.
    </p>

    <div class="grid md:grid-cols-3 gap-6">
      <div v-for="(step, index) in steps" :key="index" class="bg-white rounded-xl shadow-md p-6 text-left">
        <div class="text-blue-900 text-2xl font-bold mb-2"> <font-awesome-icon :icon="['fas', 'square-check']" class="me-1 text-green-600"/> Step {{ index + 1 }}</div>
        <hr class="">
        <h3 class="text-lg font-semibold mb-1">{{ step.title }}</h3>
        <p class="text-sm text-gray-600">{{ step.description }}</p>
      </div>
    </div>
  </div>
</section>


</template>

<style scoped>

</style>
