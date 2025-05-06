<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Step 1: Book For An Appointment To View The Desired Cottage
            </h2>
        </template>

        <form @submit.prevent="submit" class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
            <h2 class="text-lg font-bold mb-4">Book a Viewing Appointment</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700">Preferred Date</label>
                <input type="date" v-model="form.preferred_date" class="mt-1 block w-full border rounded" required>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Preferred Time</label>
                <input type="time" v-model="form.preferred_time" class="mt-1 block w-full border rounded" required>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Message (optional)</label>
                <textarea v-model="form.message" class="mt-1 block w-full border rounded"></textarea>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Appointment Request
            </button>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    preferred_date: '',
    preferred_time: '',
    message: '',
    cottage_id: 1 // Replace with a prop or dynamic value if needed
});

const submit = () => {
    form.post(route('appointments.store'));
};
</script>
