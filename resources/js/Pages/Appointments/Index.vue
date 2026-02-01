<template>
    <AuthenticatedLayout>
        <div class="p-6 mt-4 mx-4 bg-white">
            <h1 class="text-2xl font-bold mb-4">My Appointments</h1>

            <div v-if="user_appointments.length" class="grid gap-4">
                <div v-for="appointment in user_appointments" :key="appointment.id"
                    class="relative p-4 border rounded-lg shadow-sm bg-white">
                    <!-- Appointment Info -->
                    <div>
                        <p class="text-lg font-semibold">Date: {{ appointment.preferred_date }}</p>
                        <p>Status: {{ appointment.status }}</p>
                        <p>Client: {{ appointment.message || 'N/A' }}</p>
                    </div>

                    <!-- Kebab Menu -->
                        <div class="absolute top-4 " @click.away="closeMenu(appointment.id)">
                            <button @click="toggleMenu(appointment.id)"
                                class=" bg-blue-500 px-3 py-1 rounded-sm hover:bg-blue-600 focus:outline-hidden">
                                ⋮ Action
                            </button>

                            <div v-if="activeMenu === appointment.id"
                                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 shadow-lg rounded-md z-10">
                                <ul class="text-sm text-gray-700">
                                    <li @click="view(appointment)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                        View</li>
                                    <li @click="edit(appointment)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                        Edit</li>
                                    <li @click="deleteAppointment(appointment)"
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-red-500">Delete</li>
                                </ul>
                            </div>
                        </div>

                </div>
            </div>

            <div v-else>
                <p>No appointments found.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'

const props = defineProps({
    user_appointments: Array,
})

// Menu state
const activeMenu = ref(null)

function toggleMenu(id) {
    activeMenu.value = activeMenu.value === id ? null : id
}

function closeMenu(id) {
    if (activeMenu.value === id) {
        activeMenu.value = null
    }
}

// Action handlers (replace with real logic or emit events)
function view(appointment) {
    alert('Viewing appointment: ' + appointment.id)
}

function edit(appointment) {
    alert('Editing appointment: ' + appointment.id)
}

function deleteAppointment(appointment) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        alert('Deleted appointment: ' + appointment.id)
    }
}
</script>
