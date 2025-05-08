<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="lg:text-xl font-semibold leading-tight text-gray-800">
                Step 1: Book For An Appointment To View The Desired Cottage
            </h2>

        </template>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 lg:ps-12 ps-6 pt-6">
            Enter your appointment details below
        </h2>
        <div class="lg:flex lg:justify-center lg:items-start my-10 space-x-8 lg:ps-12  ">
            <!-- form card -->

            <form @submit.prevent="submit" class="lg:w-3/4 p-6 bg-white rounded shadow ">

                <h2 class="text-lg font-bold mb-4">Book a Viewing Appointment</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Cottage Number</label>
                    <select v-model="form.cottage_number" class="mt-1 block w-full border rounded px-2 py-2" required>
                        <option value="" disabled>Select a cottage</option>
                        <option v-for="num in 25" :key="num" :value="num">
                            Cottage {{ num }}
                        </option>
                    </select>
                    <p v-if="form.errors.cottage_number" class="text-red-600 text-sm mt-1">
                        {{ form.errors.cottage_number }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Preferred Date</label>
                    <input type="date" v-model="form.preferred_date" class="mt-1 block w-full border rounded" required>
                    <p v-if="form.errors.preferred_date" class="text-red-600 text-sm mt-1">
                        {{ form.errors.preferred_date }}
                    </p>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Preferred Time</label>
                    <input type="time" v-model="form.preferred_time" class="mt-1 block w-full border rounded" required>
                    <p v-if="form.errors.preferred_time" class="text-red-600 text-sm mt-1">
                        {{ form.errors.preferred_time }}
                    </p>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Message (optional)</label>
                    <textarea v-model="form.message" class="mt-1 block w-full border rounded"></textarea>
                    <p v-if="form.errors.message" class="text-red-600 text-sm mt-1">
                        {{ form.errors.message }}
                    </p>
                </div>

                <button type="submit" class="mt-4 bg-btn text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit Appointment Request
                </button>
            </form>

            <!-- summary card -->
            <div class="lg:w-1/2 w-4/5 p-6 me-6 bg-gray-400 rounded shadow sticky top-6 h-fit">
                <h2 class="text-xl font-bold mb-4  border-b border-gray-300">Your Appointment Summary</h2>
                <div class="space-y-2 text-sm lg:me-4 text-gray-700">
                    <p><strong>Cottage Number:</strong>
                    <p class="text-xl"> {{ form.cottage_number || 'Not selected' }}</p>
                    </p>
                    <p><strong>Preferred Appointment Date:</strong>
                    <p class="text-xl"> {{ form.preferred_date || 'Not selected' }}</p>
                    </p>
                    <p class="mt-2"><strong>Time:</strong>
                    <p class="text-xl"> {{ form.preferred_time || 'Not selected' }}</p>
                    </p>
                    <p class="mt-2"><strong>Message:</strong>
                    <p class="text-xl">{{ form.message || 'No message provided' }}</p>
                    </p>
                </div>
            </div>
        </div>
        <Footer />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Footer from '@/Shared/Footer.vue';
import Swal from 'sweetalert2'

const form = useForm({
    preferred_date: '',
    preferred_time: '',
    message: '',
    cottage_number: '' // Replace with a prop or dynamic value if needed
});


const submit = () => {
    form.post(route('appointments.store'),
    {
    onSuccess: () => {
      Swal.fire({
        title: 'Success!',
        text: 'Appointment successfully booked',
        icon: 'success',
        confirmButtonText: 'Okay',
        confirmButtonColor:'#008000'
      });
    },
    onError: () => {
      Swal.fire({
        title: 'Error!',
        text: 'Please correct the errors and try again.',
        icon: 'error',
        confirmButtonText: 'Ok',
        confirmButtonColor: '#008000',
      });
    }
});
};



</script>

<style>
.bg-btn {
    background-color: darkcyan;
}
</style>
