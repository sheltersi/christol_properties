<script setup>
import { router, usePage } from '@inertiajs/vue3';
import ReusableTable from '@/Components/Table.vue';
import {debounce} from 'lodash'
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  applications: Object,
  filters: Object,
});

const search = ref(props.filters.search || '');

// Refetch when search changes
watch(search, (val) => {
    console.log('Searching for:', val);
  router.get(route('applications.index'), { search: val }, { preserveState: true, replace: true });
});

// watch(search, debounce((val) => {
//   router.get(route('all-applications.index'), { search: val }, { preserveState: true, replace: true });
// }, 300));

const columns = [
  { key: 'id', label: 'ID' },
  { key: 'user.first_name', label: 'User' },
  { key: 'occupants', label: 'Occupants' },
  { key: 'phone', label: 'Phone' },
  { key: 'id_number', label: 'ID' },
//   { key: 'agree', label: 'Agree' },
  { key: 'status', label: 'Status' },
];

const rows = props.applications.data.map(item => ({
  ...item,
  'user.first_name': item.user?.first_name || 'N/A',
}));

const viewApplication = (id) => {
    router.get(route('tenant.applications',id));
};

// const confirmAppointment = (id) => {
//     if (confirm('Are you sure you want to confirm this appointment?')){
//         router.put(route('applications.confirm', id),{}, {
//             onSuccess: () => {
//                 console.log('Appointment confirmed')
//             }
//         });
//     }
// };
</script>

<template #actions="{row}">
    <AuthenticatedLayout>

  <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
    <div>
        <h1 class="text-xl font-bold mt-4 m-4">All Submitted Applications</h1>
        <hr>
</div>
    <input
      v-model="search"
      placeholder="Search by user name"
      class="border px-2 py-1 rounded w-full max-w-sm"
    />

    <ReusableTable :columns="columns" :rows="rows" :pagination="applications.links">
        <template #status="{ row }">
    <span
      class="px-2 py-1 text-xs font-semibold rounded-full"
      :class="{
        'bg-yellow-100 text-yellow-800': row.status === 'pending',
        'bg-green-100 text-green-800': row.status === 'accepted',
        'bg-red-100 text-red-800': row.status === 'declined',
           'bg-red-100 text-pink-400': row.status === 'in-progress',
           'bg-red-100 text-blue-400': row.status === 'viewed',

      }"
    >
      {{ row.status }}
    </span>
  </template>
      <template #actions="{ row }">
        <button
        @click="viewApplication(row.id)"
        class="text-sm text-blue-600 hover:underline mr-2">View</button>
        <button
        v-if="row.status === 'pending'"
        class="text-sm text-green-700 hover:underline">Accept</button>
        <button
        v-if="row.status === 'accepted'"
        class="text-sm text-red-700 hover:underline">Revoke</button>

      </template>
    </ReusableTable>
  </div>
  </AuthenticatedLayout>
</template>
