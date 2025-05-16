<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  tenant: Object,
  cottage: Object,
//   payments: Object,
  appointments: Array,
//   maintenance: Array,
});
</script>

<template>
  <Head title="My Dashboard" />
  <AuthenticatedLayout>
    <div class="p-6 space-y-6">
      <h1 class="text-2xl font-bold">Hello, {{ tenant.first_name }} 👋</h1>

      <!-- Cottage Info -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">🏡 My Cottage</h2>
        <p><strong>Number:</strong> {{ cottage?.number || "NA" }}</p>
        <p><strong>Location:</strong> {{ cottage?.location || "NA" }}</p>
        <p><strong>Monthly Rent:</strong> R{{ cottage?.price_per_month || "NA" }}</p>
        <p><strong>Status:</strong> {{ cottage?.status || "NA"}}</p>
      </div>

      <!-- Payment Info -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">💳 Payments</h2>
        <p><strong>Last Payment:</strong> {{ payments?.last_payment_date ?? 'No payments yet' }}</p>
        <p><strong>Balance:</strong> R{{ payments?.balance_due || "NA" }}</p>
        <Link href="/tenant/payments" class="text-blue-600 hover:underline">View payment history</Link>
      </div>

      <!-- Maintenance -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">🛠 Maintenance Requests</h2>
        <ul>
          <!-- <li v-for="req in maintenance" :key="req.id"> -->
          <li>
            <!-- {{ req.issue }} - <span class="text-sm text-gray-500">{{ req.status }}</span> -->
            <span class="text-sm text-gray-500">No maintenance needed yet</span>

          </li>
        </ul>
        <Link href="#" class="mt-2 inline-block text-blue-600 hover:underline">New request</Link>
      </div>

      <!-- Appointments -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">📅 Upcoming Appointments</h2>
        <ul>
          <li v-for="appt in appointments" :key="appt.id">
            {{ appt?.preferred_date || "NA" }} at {{ appt?.preferred_time || "NA" }} - <span class="text-sm text-gray-500">{{ appt?.status || "NA" }}</span>
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
