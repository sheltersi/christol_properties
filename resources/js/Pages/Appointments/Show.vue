<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
const props = defineProps({
  appointment: Object,
});
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 space-y-4">
      <h2 class="text-2xl font-bold">Appointment Details</h2>
      <div class="space-y-2">
        <p><strong>User:</strong> {{ appointment.user.first_name }} {{ appointment.user.last_name }}</p>
        <p><strong>Cottage No:</strong> {{ appointment.cottage_number }}</p>
        <p><strong>Date:</strong> {{ appointment.preferred_date }}</p>
        <p><strong>Time:</strong> {{ appointment.preferred_time }}</p>
        <p><strong>Status:</strong> {{ appointment.status }}</p>
        <p><strong>Comments:</strong> {{ appointment.comments ?? 'N/A' }}</p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
