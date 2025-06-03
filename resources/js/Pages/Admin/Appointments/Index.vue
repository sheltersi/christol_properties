<script setup>
import { router, usePage} from '@inertiajs/vue3';
import { computed } from 'vue';
import ReusableTable from '@/Components/Table.vue';
import {debounce} from 'lodash'
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();

const props = defineProps(['appointments', 'filters']);

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

const search = ref(page.props.filters?.search || '');

watch(search, (value) => {
  router.get(route('all-appointments.index'), { search: value }, {
    preserveScroll: true,
    replace: true,
  });
});

const columns = [
  { key: 'id', label: 'ID' },
  { key: 'user.full_name', label: 'User' },
  { key: 'cottage_number', label: 'Cottage No' },
  { key: 'preferred_date', label: 'Date' },
  { key: 'preferred_time', label: 'Time' },
  { key: 'status', label: 'Status' },
];

const rows = props.appointments.data.map(item => ({
  ...item,
  'user.full_name': item.user?.full_name || 'N/A',
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



const activeStatus = computed(() => page.props.filters?.status ?? 'all');

function filterAppointments(status){
    activeStatus.value = status;

    router.get(route('all-appointments.index'),{status},{
        replace: true,
        preserveScroll: true,
        // preserveState: true,
    });
}


function filterToday() {
  activeStatus.value = 'today';

  router.get(route('all-appointments.index'), { status: 'today' }, {
    replace: true,
    preserveScroll: true,
  });
}

const showProposeModal = ref(false);
const newAppointmentTime = ref('');
const selectedAppointment = ref(null);

function openProposeTimeModal(row) {
  selectedAppointment.value = row;
  newAppointmentTime.value = '';
  showProposeModal.value = true;
}

function submitProposedTime() {
  if (!selectedAppointment.value || !newAppointmentTime.value) return;

  router.post(route('appointments.propose-time', selectedAppointment.value.id), {
    new_time: newAppointmentTime.value
  }, {
    onSuccess: () => {
      showProposeModal.value = false;
      selectedAppointment.value = null;
    },
    onError: () => {
      alert('Something went wrong while proposing time.');
    }
  });
}


</script>

<template #actions="{row}">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mt-4 m-4">
    <h1 class="text-2xl font-bold">All Booked Appointments</h1>

    <!-- Button Group -->
    <div class="flex space-x-2">
        <button
        :class="[activeStatus === 'upcoming' ? 'bg-blue-600 text-white' : 'up-btns']"
        @click="filterAppointments('upcoming')" >
            Upcoming Appointments
        </button>
        <button
        :class="[activeStatus === 'expired' ? 'bg-blue-600 text-white' : 'up-btns']"
        @click="filterAppointments('expired')" >
            Expired Appointments
        </button>
    </div>
</div>
<hr>
<!-- Extended Filters -->
<div class="flex flex-wrap justify-end gap-2 mx-4 mt-2">
    <button
    :class="[activeStatus === 'all' ? 'bg-green-600 text-white' : 'btn']"
    @click="() => filterAppointments('all')"
    >All</button>
    <button :class="[activeStatus === 'pending' ? 'bg-green-600 text-white' : 'btn']"
    @click="() => filterAppointments('pending')"
     >Pending</button>
    <button
    :class="[activeStatus === 'confirmed' ? 'bg-green-600 text-white' : 'btn']"
    @click="() => filterAppointments('confirmed')"
    >Confirmed</button>
    <button
      :class="[activeStatus === 'declined' ? 'bg-green-600 text-white' : 'btn']"
    @click="() => filterAppointments('declined')"
    >Declined</button>
    <button
      :class="[activeStatus === 'revoked' ? 'bg-green-600 text-white' : 'btn']"
    @click="() => filterAppointments('revoked')"
    >Revoked</button>
    <button
    :class="[activeStatus === 'today' ? 'bg-green-600 text-white' : 'btn']"
    @click="filterToday"
    >Today</button>
    <!-- <button @click="filterAppointments('all')" class="btn bg-green-600 text-white hover:bg-green-700">Add New</button> -->
</div>

  <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
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
        v-if="row.status === 'pending'"
        @click="confirmAppointment(row.id)"
        class="text-sm text-red-700 hover:underline ms-2">Decline</button>
        <button
        v-if="row.status === 'confirmed'"
        @click="openRevokeModal(row.id)"
        class="text-sm text-red-700 hover:underline">Revoke</button>
        <button
        v-if="['pending', 'declined'].includes(row.status)"
        @click="openProposeTimeModal(row)"
        class="text-sm text-purple-600 hover:underline ml-2">Propose New Time</button>
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
<teleport to="body">
  <div
    v-if="showProposeModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Propose New Appointment Time</h2>
      <p class="mb-2 text-sm">Select a new date and time:</p>
      <input type="datetime-local" v-model="newAppointmentTime" class="w-full border rounded px-3 py-2 mb-4" />
      <div class="flex justify-end space-x-2">
        <button
          @click="showProposeModal = false"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
        >Cancel</button>
        <button
          @click="submitProposedTime"
          :disabled="!newAppointmentTime"
          class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
        >Submit</button>
      </div>
    </div>
  </div>
</teleport>

  </AuthenticatedLayout>
</template>


<style scoped>
.btn {
  @apply px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm;
}
.up-btns {
    @apply px-4 py-2 bg-green-900 text-white rounded hover:bg-green-700
}
button {
    @apply px-4 py-2 rounded;
}
</style>
