<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  stats: Object,
  recentAppointments: Array,
  notifications: Array,
});
</script>

<template>
  <Head title="Admin Dashboard" />
  <AuthenticatedLayout>
    <div class="p-6 space-y-6">
      <h1 class="text-3xl font-bold">Welcome back, Admin</h1>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white shadow rounded-xl p-4">
          <p class="text-sm text-gray-500">Total Cottages</p>
          <p class="text-2xl font-bold">{{ stats.totalCottages }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
          <p class="text-sm text-gray-500">Upcoming Appointments</p>
          <p class="text-2xl font-bold">{{ stats.upcomingAppointments }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
          <p class="text-sm text-gray-500">Registered Users</p>
          <p class="text-2xl font-bold">{{ stats.totalUsers }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
          <p class="text-sm text-gray-500">Pending Payments</p>
          <p class="text-2xl font-bold text-red-500">{{ stats.pendingPayments }}</p>
        </div>
      </div>

      <!-- Today's Appointments -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-xl font-semibold mb-4">Today's Appointments</h2>
        <table class="min-w-full text-sm text-left">
          <thead>
            <tr>
              <th class="px-4 py-2">Time</th>
              <th class="px-4 py-2">User</th>
              <th class="px-4 py-2">Cottage</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appt in recentAppointments" :key="appt.id" class="border-t">
              <td class="px-4 py-2">{{ appt.preferred_time }}</td>
              <td class="px-4 py-2">{{ appt.user.first_name }} {{ appt.user.last_name }}</td>
              <td class="px-4 py-2">{{ appt.cottage_number }}</td>
              <td class="px-4 py-2">
                <span :class="{
                  'text-green-600': appt.status === 'confirmed',
                  'text-yellow-500': appt.status === 'pending',
                  'text-red-600': appt.status === 'canceled'
                }">{{ appt.status }}</span>
              </td>
              <td class="px-4 py-2">
                <Link :href="`/appointments/${appt.id}`" class="text-blue-500 hover:underline">View</Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Notifications -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>
        <ul class="list-disc pl-5 space-y-2">
          <li v-for="note in notifications" :key="note.id">{{ note.message }}</li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
