<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    application: Object,
});

const backButton = () => {
    router.get(route('applications.index'))
};

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6 mt-4 mx-4">
            <h2 class="text-3xl font-semibold mb-4">
                {{ application.user.first_name }}'s Tenant Application
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-xl shadow-sm border">

                <!-- Personal Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Personal Information</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><span class="font-medium text-gray-800">Full Name:</span> {{ application.user.first_name }}
                            {{ application.user.last_name }}</li>
                        <li><span class="font-medium text-gray-800">Phone Number:</span> {{ application.phone }}</li>
                        <li><span class="font-medium text-gray-800">Date of Birth:</span> {{ application.dob }}</li>
                        <li><span class="font-medium text-gray-800">ID / Passport:</span> {{ application.id_number }}
                        </li>
                        <li><span class="font-medium text-gray-800">Current Address:</span> {{
                            application.current_address }}</li>
                        <li><span class="font-medium text-gray-800">Occupants:</span> {{ application.occupants ?? 'N/A'
                            }}</li>
                        <li><span class="font-medium text-gray-800">Pets:</span> {{ application.pets ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Employment Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Employment Details</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><span class="font-medium text-gray-800">Employer:</span> {{ application.employer ?? 'N/A' }}
                        </li>
                        <li><span class="font-medium text-gray-800">Job Title:</span> {{ application.job_title ?? 'N/A'
                            }}</li>
                        <li><span class="font-medium text-gray-800">Start Date:</span> {{ application.employment_start
                            ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-800">Monthly Income:</span> {{ application.monthly_income
                            ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-800">Employer Contact:</span> {{
                            application.employer_contact ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Rental Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Rental History</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><span class="font-medium text-gray-800">Landlord Name:</span> {{ application.landlord_name
                            ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-800">Landlord Contact:</span> {{
                            application.landlord_contact ?? 'N/A' }}</li>
                        <li><span class="font-medium text-gray-800">Rent Amount:</span> {{ application.rent_amount ??
                            'N/A' }}</li>
                        <li><span class="font-medium text-gray-800">Reason for Leaving:</span> {{
                            application.reason_leaving ?? 'N/A' }}</li>
                    </ul>
                </div>

                <!-- Consent -->
                <div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Other</h3>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium text-gray-800">Credit Check Agreement:</span>
                        <span :class="application.agree
                            ? 'bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-medium'
                            : 'bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-medium'" class="ml-2 inline-block">
                            {{ application.agree ? 'Yes' : 'No' }}
                        </span>
                        <!-- {{ application.agree ? 'Yes' : 'No' }} -->
                    </p>
                </div>

            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <button @click="backButton"
                    class="px-5 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-600 text-sm">
                    Back
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<!-- have commented the below code just for design purposes -->
<!-- <template>
  <AuthenticatedLayout>
    <div class="p-6 space-y-4 mt-4 mx-4 bg-white">
      <h2 class="text-2xl font-bold">{{application.user.first_name}} Tenant application Details</h2>
      <hr>
      <div class="space-y-2">
        <p><strong>User:</strong> {{ application.user.first_name }} {{ application.user.last_name }}</p>
        <p><strong>Phone Number:</strong> {{ application.phone }}</p>
        <p><strong>Date of Birth</strong> {{ application.dob }}</p>
        <p><strong>ID Number / Passport:</strong> {{ application.id_number }}</p>
        <p><strong>Current Address:</strong> {{ application.current_address }}</p>
        <p><strong>Number of Occupants:</strong> {{ application.occupants ?? 'N/A' }}</p>
        <p><strong>Pets:</strong> {{ application.pets ?? 'N/A' }}</p>
        <p><strong>Employer:</strong> {{ application.employer ?? 'N/A' }}</p>
        <p><strong>Job Title:</strong> {{ application.job_title ?? 'N/A' }}</p>
        <p><strong>Employment Start Date:</strong> {{ application.employment_start ?? 'N/A' }}</p>
        <p><strong>Monthly Income:</strong> {{ application.monthly_income ?? 'N/A' }}</p>
        <p><strong>Employer Contanct:</strong> {{ application.employer_contact ?? 'N/A' }}</p>
        <p><strong>Landlord Name:</strong> {{ application.landlord_name ?? 'N/A' }}</p>
        <p><strong>Landlord Contanct:</strong> {{ application.landlord_contact ?? 'N/A' }}</p>
        <p><strong>Rent Amount:</strong> {{ application.rent_amount ?? 'N/A' }}</p>
        <p><strong>Reason Leaving:</strong> {{ application.reason_leaving ?? 'N/A' }}</p>
        <p><strong>Agreed to do credit check:</strong> {{ application.agree ? 'Yes' : 'No' }}</p>

    </div>
      <button
        @click="backButton()"
        class="px-4 py-2 rounded-md text-sm bg-blue-900 text-white  hover:bg-blue-600">Back</button>
    </div>
  </AuthenticatedLayout>
</template> -->
