<script setup>
import { router, usePage } from '@inertiajs/vue3';
import ReusableTable from '@/Components/Table.vue';
import {debounce} from 'lodash'
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  appointments: Object,
  filters: Object,
});

const showRevokeModal = ref(false);
const revokeReason = ref('');
const selectedAppointmentId = ref(null);

const openRevokeModal = (id) => {
  selectedAppointmentId.value = id;
  revokeReason.value = '';
  showRevokeModal.value = true;
};

const submitRevocation = () => {
  router.post(route('appointments.revoke', selectedAppointmentId.value), {
    reason: revokeReason.value,
  }, {
    onSuccess: () => {
      showRevokeModal.value = false;
      revokeReason.value = '';
    },
  });
};

const search = ref(props.filters.search || '');

// Refetch when search changes
watch(search, (val) => {
    console.log('Searching for:', val);
  router.get(route('all-appointments.index'), { search: val }, { preserveState: true, replace: true });
});

// watch(search, debounce((val) => {
//   router.get(route('all-appointments.index'), { search: val }, { preserveState: true, replace: true });
// }, 300));

const columns = [
  { key: 'id', label: 'ID' },
  { key: 'user.first_name', label: 'User' },
  { key: 'cottage_number', label: 'Cottage No' },
  { key: 'preferred_date', label: 'Date' },
  { key: 'preferred_time', label: 'Time' },
  { key: 'status', label: 'Status' },
];

const rows = props.appointments.data.map(item => ({
  ...item,
  'user.first_name': item.user?.first_name || 'N/A',
}));

const viewAppointment = (id) => {
    router.get(route('appointments.show',id));
};

const confirmAppointment = (id) => {
    if (confirm('Are you sure you want to confirm this appointment?')){
        router.put(route('appointments.confirm', id),{}, {
            onSuccess: () => {
                console.log('Appointment confirmed')
            }
        });
    }
};
</script>

<template #actions="{row}">
    <AuthenticatedLayout>
        <div>
            <h1 class="text-xl font-bold mt-4 m-4">All Booked Appointments</h1>
            <hr>
        </div>
  <div class="p-6 space-y-4">
    <input
      v-model="search"
      placeholder="Search by user name"
      class="border px-2 py-1 rounded w-full max-w-sm"
    />

    <ReusableTable :columns="columns" :rows="rows" :pagination="appointments.links">
        <template #status="{ row }">
    <span
      class="px-2 py-1 text-xs font-semibold rounded-full"
      :class="{
        'bg-yellow-100 text-yellow-800': row.status === 'pending',
        'bg-green-100 text-green-800': row.status === 'confirmed',
        'bg-red-100 text-red-800': row.status === 'declined',
        'bg-pink-100 text-pink-700': row.status === 'revoked',
      }"
    >
      {{ row.status }}
    </span>
  </template>
      <template #actions="{ row }">
        <button
        @click="viewAppointment(row.id)"
        class="text-sm text-blue-600 hover:underline mr-2">View</button>
        <button
        v-if="row.status === 'pending'"
        @click="confirmAppointment(row.id)"
        class="text-sm text-green-700 hover:underline">Confirm</button>
        <button
        v-if="row.status === 'confirmed'"
        @click="openRevokeModal(row.id)"
        class="text-sm text-red-700 hover:underline">Revoke</button>

      </template>
    </ReusableTable>
  </div>

  <teleport to="body">
  <div
    v-if="showRevokeModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Revoke Appointment</h2>
      <p class="mb-2 text-sm">Please provide a reason for revoking this appointment:</p>
      <textarea
        v-model="revokeReason"
        class="w-full border rounded px-3 py-2 mb-4"
        rows="4"
        placeholder="Enter reason here..."
      ></textarea>
      <div class="flex justify-end space-x-2">
        <button
          @click="showRevokeModal = false"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
        >Cancel</button>
        <button
          @click="submitRevocation"
          :disabled="!revokeReason.trim()"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
        >Revoke</button>
      </div>
    </div>
  </div>
</teleport>

  </AuthenticatedLayout>
</template>
