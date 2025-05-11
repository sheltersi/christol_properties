<template>
    <div>
      <h1 class="text-xl font-bold mb-4">Notifications</h1>
      <ul>
        <li v-for="notification in notifications.data" :key="notification.id" class="mb-4 p-4 border rounded">
          <p><strong>{{ notification.data.user_name }}</strong> requested an appointment on <strong>{{ notification.data.preferred_date }}</strong> at <strong>{{ notification.data.preferred_time }}</strong>.</p>
          <p v-if="notification.data.message">Message: {{ notification.data.message }}</p>
          <div class="mt-2">
            <Link :href="`/appointments/${notification.data.appointment_id}`" class="text-blue-600 hover:underline">View Appointment</Link>

            <button
            @click="markAsRead(notification.id)"
            class="text-sm text-gray-600 hover:text-green-600"
          >
            Mark as read
          </button>
        </div>
        </li>
      </ul>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
  defineProps({ notifications: Object });

  function markAsRead(id) {
  router.post(`/admin/notifications/${id}/read`, {}, {
    preserveScroll: true,
    only: ['notifications'], // only reload this prop if you want a partial reload
  })
}
  </script>
