<script setup>
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import {ref} from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const props = defineProps({
    notifications: Object
 });

 //active tab
 const activeTab = ref('all');

 //handle marking as read
function markAsRead(id) {
    router.post(`/admin/notifications/${id}/read`, {}, {
        preserveScroll: true,
        only: ['notifications'], // only reload this prop if you want a partial reload
    })
}

//filter logic
const filteredNotifications = computed(()=>{
    if (activeTab.value === 'unread') {
        return props.notifications.filter(n => !n.read_at)
    }
    if (activeTab.value === 'read') {
        return props.notifications.filter(n => n.read_at)
    }
    return props.notifications
});
</script>

<template>

    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>

        <template #header>
            <h1 class="text-3xl font-bold">🔔 List Notification</h1>
            <hr class="w-[340px] rounded-md border-y-4 border-cyan-500 mt-2">
        </template>

        <div>
            <h1 class="font-bold ms-4 p-2">{{ notifications.length }} Notification</h1>
            <!-- TODO::Add a seach bar for notifications, has to be in the same line with this notification length -->
            <ul>
                <li v-for="notification in notifications" :key="notification.id" class="mb-4 p-4 border rounded">
                    <p><strong>{{ notification.user_name }}</strong> requested an appointment on <strong>{{
                            notification.preferred_date }}</strong> at <strong>{{ notification.preferred_time
                            }}</strong>.</p>
                    <p v-if="notification.data.message">Message: {{ notification.data.message }}</p>
                    <div class="mt-2">
                        <Link :href="`/appointments/${notification.appointment_id}`"
                            class="text-blue-600 hover:underline">
                        View Appointment</Link>

                        <button @click="markAsRead(notification.id)" class="text-sm text-gray-600 hover:text-green-600">
                            Mark as read
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
