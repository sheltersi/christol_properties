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
  <Head title="My Dashboard"/>

  <AuthenticatedLayout>
        <template #header>
      <h1 class="text-2xl font-bold">Hello, {{ tenant.user?.first_name }} 👋</h1>
            <hr class="greeting-border w-44 mt-2 border-cyan-600">
        </template>
        <div class="p-6 space-y-6">
      <!-- Cottage Info -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">🏡 My Unit</h2>
        <p><strong>Unit Number:</strong> {{ tenant.current_lease?.cottage.number || "NA" }}</p>
        <p><strong>Location:</strong> {{ tenant.current_lease?.cottage.location || "NA" }}</p>
        <p><strong>Monthly Rent:</strong> R{{ tenant.current_lease?.cottage.price_per_month || "NA" }}</p>
      </div>

      <!-- Payment Info -->
      <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold">💳 Rent Status</h2>
        <p><strong>Last Payment updated date:</strong> {{ tenant.current_lease.current_payment.created_at ? new Date(tenant.current_lease.current_payment.created_at).toLocaleString('en-ZA', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        })
      : 'No payments yet' }}</p>
        <p><strong>Month for:</strong> {{ tenant.current_lease.current_payment.month_for ?? 'No payments yet' }}</p>
        <p><strong>Balance:</strong> R{{ tenant.current_lease.current_payment.amount_paid || "NA" }}</p>
        <p><strong>Outstanding Balance:</strong> Up-to-date</p>
        <!-- <p><strong>Status:</strong> {{ tenant.current_lease.current_payment.status ?? 'No payments yet' }}</p> -->
<p><strong>Status: </strong>
<span :class="{
  'bg-green-500 px-2.5 py-0.5 text-xs text-white rounded inline-block ': tenant.current_lease.current_payment.status === 'approved',
  'bg-yellow-500 px-2.5 py-0.5 text-xs text-white rounded inline-block': tenant.current_lease.current_payment.status === 'pending',
  'bg-red-600 px-2.5 py-0.5 text-xs text-white rounded inline-block': tenant.current_lease.current_payment.status === 'declined'
}">
  {{ tenant.current_lease.current_payment.status.charAt(0).toUpperCase() + tenant.current_lease.current_payment.status.slice(1) }}
</span></p>
        <!-- <Link href="tenants/.$tenant./payments/" class="text-blue-600 hover:underline">Update My Latest Rent Payment<br/> </Link>
        <Link :href="`/tenants/${tenant.id}/payments`" class="text-blue-600 hover:underline"> Update My Latest Rent Payment </Link> -->
       	<Link :href="route('tenant.payment.create')" class="text-cyan-600 hover:underline"> Update My Latest Rent Payment </Link>
        <!-- <Link href="/tenant/payments" class="text-blue-600 hover:underline">View payment history</Link> -->
      </div>

      <!-- Lease Info -->


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
        <Link href="#" class="mt-2 inline-block text-cyan-600 hover:underline">New request</Link>
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

<style scoped>
.greeting-border{
    border-radius: 100px;
    border-width: 5px;
}
.color{
    color:darkcyan;
}
</style>
