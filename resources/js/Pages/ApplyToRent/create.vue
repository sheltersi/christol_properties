<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Apply to Rent a Property
            </h2>
        </template>

        <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-sm shadow-sm">
            <form @submit.prevent="submit">
                <!-- Applicant Information -->
                <h3 class="text-lg font-bold mb-4">Applicant Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>Full Name</label>
                        <input v-model="form.full_name" type="text" class="input" required />
                    </div>
                    <div>
                        <label>Email</label>
                        <input v-model="form.email" type="email" class="input" required />
                    </div>
                    <div>
                        <label>Phone Number</label>
                        <input v-model="form.phone" type="text" class="input" required />
                        <p v-if="form.errors.phone" class="text-red-600 text-sm mt-1">
                        {{ form.errors.phone }}
                    </p>
                    </div>
                    <div>
                        <label>Date of Birth</label>
                        <input v-model="form.dob" type="date" class="input" required />
                        <p v-if="form.errors.dob" class="text-red-600 text-sm mt-1">
                        {{ form.errors.dob }}
                    </p>
                    </div>
                    <div>
                        <label>ID/Passport Number</label>
                        <input v-model="form.id_number" type="text" class="input" required />
                        <p v-if="form.errors.id_number" class="text-red-600 text-sm mt-1">
                        {{ form.errors.id_number }}
                    </p>
                    </div>
                    <div>
                        <label>Current Address</label>
                        <input v-model="form.current_address" type="text" class="input" required />
                    </div>
                </div>

                <!-- Household Info -->
                <h3 class="text-lg font-bold mt-8 mb-4">Household Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>Number of Occupants</label>
                        <input v-model="form.occupants" type="number" class="input" required />
                    </div>
                    <!-- <div>
              <label>Pets</label>
              <input v-model="form.pets" type="text" class="input" placeholder="e.g., Dog - 2 yrs old" />
            </div> -->
                    <!-- Names and Ages of Other Occupants -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Other Occupants (names and ages)</label>
                        <textarea v-model="form.occupants" class="mt-1 block w-full rounded-sm border-gray-300"
                            placeholder="e.g. John (30), Mary (5)"></textarea>
                    </div>

                    <!-- Pets -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Do you have pets?</label>
                        <select v-model="form.has_pets" class="mt-1 block w-full rounded-sm border-gray-300">
                            <option value="" disabled>Select an option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div v-if="form.has_pets === 'yes'">
                        <label class="block font-medium text-sm text-gray-700">Pet Details</label>
                        <textarea v-model="form.pet_details" class="mt-1 block w-full rounded-sm border-gray-300"
                            placeholder="e.g. 2 dogs (small breeds)"></textarea>
                    </div>
                </div>

                <!-- Employment Info -->
                <h3 class="text-lg font-bold mt-8 mb-4">Employment & Income</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>Employer Name</label>
                        <input v-model="form.employer" type="text" class="input" required />
                    </div>
                    <div>
                        <label>Job Title</label>
                        <input v-model="form.job_title" type="text" class="input" required />
                    </div>
                    <div>
                        <label>Employment Start Date</label>
                        <input v-model="form.employment_start" type="date" class="input" />
                    </div>
                    <div>
                        <label>Monthly Income</label>
                        <input v-model="form.monthly_income" type="number" class="input" required />
                    </div>
                    <div>
                        <label>Employer Contact Info</label>
                        <input v-model="form.employer_contact" type="text" class="input" />
                    </div>
                </div>

                <!-- Rental History -->
                <h3 class="text-lg font-bold mt-8 mb-4">Rental History</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>Current Landlord Name</label>
                        <input v-model="form.landlord_name" type="text" class="input" />
                    </div>
                    <div>
                        <label>Landlord Contact</label>
                        <input v-model="form.landlord_contact" type="text" class="input" />
                    </div>
                    <div>
                        <label>Current Rent Amount</label>
                        <input v-model="form.rent_amount" type="number" class="input" />
                    </div>
                    <div>
                        <label>Reason for Leaving</label>
                        <input v-model="form.reason_leaving" type="text" class="input" />
                    </div>
                </div>

                <h3 class="text-lg font-bold mt-8 mb-4">Supporting documents</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="">
                        <label>Copy of ID/passport</label>
                        <input type="file" @change="e => form.id_copy = e.target.files[0]" />
                    </div>
                    <div class="mt-4">
                        <label>Latest payslip or proof of income</label>
                        <input type="file" @change="e => form.payslip = e.target.files[0]" />
                    </div>

                    <div class="mt-4">
                        <label>Proof of residence (optional)</label>
                        <input type="file" @change="e => form.residence_proof = e.target.files[0]" />
                    </div>
                </div>
                <!-- Declarations -->
                <h3 class="text-lg font-bold mt-8 mb-4">Declarations & Consent</h3>
                <div>
                    <label>
                        <input type="checkbox" v-model="form.agree" required />
                        I consent to a credit check and confirm that all information is accurate.
                    </label>
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-sm hover:bg-blue-700">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

const page = usePage()

const form = useForm({
    full_name: page.props.user?.full_name,
    email: page.props.user?.email,
    phone: '',
    dob: '',
    id_number: '',
    current_address: '',
    occupants: '',
    pets: '',
    employer: '',
    job_title: '',
    employment_start: '',
    monthly_income: '',
    employer_contact: '',
    landlord_name: '',
    landlord_contact: '',
    rent_amount: '',
    reason_leaving: '',
    agree: false,
    id_copy: null,
    payslip: null,
    residence_proof: null,
});

function submit() {
    form.post(route('application.store'), {
        forceFormData: true, // required for file upload
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Application successfully submitted!',
                icon: 'success',
                confirmButtonText: 'Okay',
                confirmButtonColor: '#008000'
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Please correct the errors and try again.',
                icon: 'error',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#008000'
            });
        }
    });
}


//   defineOptions({layout: AppLayout});
</script>

<style scoped>
.input {
    @apply w-full mt-1 px-3 py-2 border rounded shadow-xs focus:ring-blue-500 focus:border-blue-500;
}
</style>
