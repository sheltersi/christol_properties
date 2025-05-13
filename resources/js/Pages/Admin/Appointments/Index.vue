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
    router.get(route('appointments.show','id'));
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
  <div class="p-6 space-y-4">
    <input
      v-model="search"
      placeholder="Search by user name"
      class="border px-2 py-1 rounded w-full max-w-sm"
    />

    <ReusableTable :columns="columns" :rows="rows" :pagination="appointments.links">
      <template #actions="{ row }">
        <button
        @click="viewAppointment"
        class="text-sm text-blue-600 hover:underline mr-2">View</button>
        <button
        @click="confirmAppointment(row.id)"
        class="text-sm text-yellow-400 hover:underline">Confirm</button>

      </template>
    </ReusableTable>
  </div>
  </AuthenticatedLayout>
</template>
