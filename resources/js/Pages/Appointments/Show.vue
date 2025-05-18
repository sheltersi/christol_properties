<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  appointment: Object,
});

const backButton = () => {
    router.get(route('all-appointments.index'))
};
// const viewAppointment = (id) => {
//     router.get(route('appointments.show',id));
// };

</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
      <h2 class="text-2xl font-bold">{{appointment.user.first_name}} Tenant Appointment Details</h2>
      <hr>
      <div class="space-y-2">
        <p><strong>User:</strong> {{ appointment.user.first_name }} {{ appointment.user.last_name }}</p>
        <p><strong>Cottage No:</strong> {{ appointment.cottage_number }}</p>
        <p><strong>Date:</strong> {{ appointment.preferred_date }}</p>
        <p><strong>Time:</strong> {{ appointment.preferred_time }}</p>
        <p><strong>Status:</strong> {{ appointment.status }}</p>
        <p><strong>Comments:</strong> {{ appointment.comments ?? 'N/A' }}</p>
      </div>
      <button
        @click="backButton()"
        class="px-4 py-2 rounded-md text-sm bg-blue-900 text-white  hover:bg-blue-600">Back</button>
    </div>
  </AuthenticatedLayout>
</template>
