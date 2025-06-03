<script setup>
import { router, usePage } from '@inertiajs/vue3';
import ReusableTable from '@/Components/Table.vue';
import { debounce } from 'lodash'
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import ActionDropdown from '@/Components/ActionDropdown.vue';
import { Transition } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ReasonModal from '@/Components/ReasonModal.vue'

const components = { Menu, MenuButton, MenuItems, MenuItem, Transition };

const page = usePage();

const props = defineProps({
    applications: Object,
    filters: Object,
});

const showRevokeModal = ref(false)
const showDeclineModal = ref(false)
const selectedApplicationId = ref(null)
const selectedAppId = ref(null)

const submitRevocation = (reason) => {
  router.post(
    route('revoke.applications', selectedApplicationId.value),
    { reason },
    {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        showRevokeModal.value = false
      },
    }
  )
}

const openModal = (modalType, id) => {
  if (modalType === 'decline') {
    selectedAppId.value = id;
    showDeclineModal.value = true;
  } else if (modalType === 'revoke') {
    selectedApplicationId.value = id;
    showRevokeModal.value = true;
  }
};

const submitDeclination = (reason) => {
  router.post(
    route('decline.applications', selectedAppId.value),
    { reason },
    {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        showDeclineModal.value = false
      },
    }
  )
};

const search = ref(props.filters.search || '');

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
    router.get(route('tenant.applications', id));
};

const acceptApplication = (id) => {
    router.post(route('accept.applications', id));
};

const declineApplication = (id) => {
    router.post(route('decline.applications', id));
};

const revokeApplication = (id) => {
    router.post(route('revoke.applications', id));
};


</script>


<template #actions="{row}">
    <AuthenticatedLayout>

        <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
            <div>
                <h1 class="text-xl font-bold mt-4 m-4">All Submitted Applications</h1>
                <hr>
            </div>
            <input v-model="search" placeholder="Search by user name"
                class="border px-2 py-1 rounded w-full max-w-sm" />

            <ReusableTable :columns="columns" :rows="rows" :pagination="applications.links">
                <template #status="{ row }">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full" :class="{
                        'bg-yellow-100 text-yellow-800': row.status === 'pending',
                        'bg-green-100 text-green-800': row.status === 'accepted',
                        'bg-red-100 text-red-800': row.status === 'declined',
                        'bg-red-100 text-pink-400': row.status === 'in-progress',
                        'bg-red-100 text-blue-400': row.status === 'viewed',

                    }">
                        {{ row.status }}
                    </span>
                </template>
                <template #actions="{ row }">
                    <Dropdown :align="right" width="48">

                        <template #trigger>
                            <button
                                class="user-cicle bg-a inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
                                Actions
                                <font-awesome-icon :icon="['fas', 'angle-down']" class="ms-2" />
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink @click="viewApplication(row.id)">View</DropdownLink>
                            <DropdownLink @click="acceptApplication(row.id)" v-if="row.status === 'pending'">Accept
                            </DropdownLink>
                            <DropdownLink @click="openModal('decline', row.id)" v-if="row.status === 'pending'"
                                class="text-sm text-red-700 hover:underline">Decline
                            </DropdownLink>
                            <DropdownLink @click="openModal('revoke', row.id)" v-if="row.status === 'accepted'"
                                class="text-sm text-red-700 hover:underline">Revoke</DropdownLink>

                        </template>
                    </Dropdown>
                </template>
            </ReusableTable>
        </div>
<ReasonModal
  v-model="showDeclineModal"
  title="Decline Application"
  description="Please provide a reason for declining this application:"
  submit-label="Decline"
  @submit="submitDeclination"
/>
<ReasonModal
  v-model="showRevokeModal"
  title="Revoke Application"
  description="Please provide a reason for revoking this application:"
  submit-label="Revoke"
  @submit="submitRevocation"
/>
    </AuthenticatedLayout>
</template>
