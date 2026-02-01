<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  stats: Object,
  recentAppointments: Array,
  notifications: Array,
  tenants:Array,
  pendingPayments:Array,
  partialPayments:Array

});
</script>

<template>
  <Head title="Admin Dashboard" />
  <AuthenticatedLayout>
    <template #header>
<h1 class="text-3xl font-bold">Welcome back, Admin</h1>
<hr class="w-[340px] rounded-md border-y-8 border-cyan-500 mt-2">
        </template>
    <div class="p-6 space-y-6">

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">🏘️ Total Cottages</p>
          <p class="text-2xl font-bold">{{ stats.totalCottages }}</p>
        </div>
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">🏘️ Total tenants</p>
          <p class="text-2xl font-bold">{{ stats.totalTenants }}</p>
        </div>
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">✅ Rent Paid (This Month)</p>
          <p class="text-2xl font-bold">
            R{{ Number(stats.rentPaid).toLocaleString() }}
        </p>
        </div>
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">⏳ Amount left</p>
          <p class="text-2xl font-bold">R{{Number(stats.rentLeft).toLocaleString()}}</p>
        </div>
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">❌ Unpaid Tenant</p>
          <p class="text-2xl font-bold">{{ Number(stats.rentLeft).toLocaleString() }}</p>
        </div>
        <div class="bg-white shadow-sm rounded-xl p-4">
          <p class="text-sm text-gray-500">📑 Lease Expiring Soon</p>
          <p class="text-2xl font-bold text-red-500">{{ stats.pendingPayments }}</p>
        </div>
      </div>

      <!-- Today's Appointments -->
      <div class="bg-white shadow-sm rounded-xl p-4">
        <h2 class="text-xl font-semibold mb-4">Pending Confirmations</h2>
        <table class="min-w-full text-sm text-left">
          <thead>
            <tr>
              <th class="px-4 py-2">Tenant Name</th>
              <th class="px-4 py-2">Cottage</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appt in recentAppointments" :key="appt.id" class="border-t">
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
        <div class="bg-white shadow-sm rounded-xl p-4">
        <h2 class="text-xl font-semibold mb-4">💰 Total Income In A Month</h2>
        <p>R{{ Number(stats.rentDue).toLocaleString() }}</p>
        </div>

      <!-- Notifications -->
      <div class="bg-white shadow-sm rounded-xl p-4">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>
        <ul class="list-disc pl-5 space-y-2">
          <li v-for="note in notifications" :key="note.id">{{ note.message }}</li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
