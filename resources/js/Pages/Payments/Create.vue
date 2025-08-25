<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BackButton from '@/Components/BackButton.vue';


// defineOptions({ layout: AppLayout })

defineProps({
    tenant: Object,
    payment: Object
});


const form = useForm({
    amount_paid: '',
    date: '',
    month_for:'',
    reference: '',
    proof: null,
})

const handleFileUpload = (e) => {
    form.proof = e.target.files[0]
}

const submitForm = () => {
    form.post(route('tenant.payment.store'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Payment submitted successfully!')
        },
    })
};

</script>

<template>
      <Head title="Create Payment"/>
<AuthenticatedLayout>

    <template #header>
        <h2 class="text-xl font-bold mb-4">Update Latest Rent Payment</h2>
    </template>


    <div class="max-w-2xl mx-auto bg-white shadow rounded-xl p-6 mt-8">

        <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium mb-1" for="amount">Amount Paid (ZAR)</label>
                <input v-model="form.amount_paid" type="number" step="0.01" id="amount"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required />
            </div>

            <div>
                <label class="block font-medium mb-1" for="date">Payment Date</label>
                <input v-model="form.date" type="date" id="date"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required />
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="month">Select Month You Paid For</label>
                <input v-model="form.month_for" type="month" id="month"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required />
            </div>

            <div>
                <label class="block font-medium mb-1" for="reference">Payment Reference</label>
                <input v-model="form.reference" type="text" id="reference"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required />
            </div>

            <div>
                <label class="block font-medium mb-1" for="proof">Proof of Payment (PDF/Image)</label>
                <input @change="handleFileUpload" type="file" id="proof" accept=".pdf,image/*"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div class="flex pt-4">
                <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit Payment
                </PrimaryButton>


            </div>
        </form>
        <div class="flex justify-end">
              <BackButton :href="route('tenant.dashboard')" class="">
                    Back
                </BackButton>
        </div>

    </div>
    </AuthenticatedLayout>
</template>
