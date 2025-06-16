<script setup>
import { computed } from 'vue';
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

const activeStatus = computed(() => page.props.filters?.status ?? 'all');
function filterAppointments(status){
    activeStatus.value = status;

    router.get(route('all-applications.index'),{status},{
        replace: true,
        preserveScroll: true,
        // preserveState: true,
    });
}


</script>


<template #actions="{row}">
    <AuthenticatedLayout>

        <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
            <div>
                <h1 class="text-xl font-bold mt-4 m-4">All Submitted Applications</h1>
                <hr>
            </div>

            <!-- Extended Filters -->
            <div class="flex flex-wrap justify-end gap-2 mx-4 mt-2">
                <button :class="[activeStatus === 'all' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('all')">All</button>
                <button :class="[activeStatus === 'pending' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('pending')">Pending</button>
                <button :class="[activeStatus === 'accepted' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('accepted')">Accepted</button>
                <button :class="[activeStatus === 'in-progress' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('in-progress')">In-progress</button>
                <button :class="[activeStatus === 'declined' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('declined')">Declined</button>
                <button :class="[activeStatus === 'revoked' ? 'bg-green-600 text-white' : 'btn']"
                    @click="() => filterAppointments('revoked')">Revoked</button>
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
                            <!-- v-if="['pending', 'in-progress'].includes(row.status)" -->
                            <DropdownLink @click="viewApplication(row.id)"
                            class="text-sm text-blue-500 hover:underline">
                                View</DropdownLink>
                            <DropdownLink @click="acceptApplication(row.id)" v-if="['pending','in-progress'].includes(row.status)"
                            class="text-sm text-green-600 hover:underline">
                                Accept
                            </DropdownLink>
                            <DropdownLink @click="creditCheck(row.id)" v-if="['pending','in-progress'].includes(row.status)"
                            class="text-sm text-green-600 hover:underline">
                                Credit check
                            </DropdownLink>
                            <DropdownLink @click="openModal('decline', row.id)" v-if="row.status === 'pending'"
                                class="text-sm text-red-700 hover:underline">Decline
                            </DropdownLink>
                            <DropdownLink @click="openModal('revoke', row.id)" v-if="['declined'].includes(row.status)"
                                class="text-sm text-red-700 hover:underline">Revoke</DropdownLink>

                        </template>
                    </Dropdown>
                </template>
            </ReusableTable>
        </div>
        <ReasonModal v-model="showDeclineModal" title="Decline Application"
            description="Please provide a reason for declining this application:" submit-label="Decline"
            @submit="submitDeclination" />
        <ReasonModal v-model="showRevokeModal" title="Revoke Application"
            description="Please provide a reason for revoking this application:" submit-label="Revoke"
            @submit="submitRevocation" />
    </AuthenticatedLayout>
</template>

<style scoped>
.btn {
  @apply px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm;
}
</style>
