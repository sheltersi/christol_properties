<template>
    <AuthenticatedLayout>
      <Head title="Apply to Rent" />

      <div class="max-w-4xl mx-auto p-6 bg-white rounded-sm shadow-sm">
        <h1 class="text-2xl font-bold mb-6">Apply to Rent This Cottage</h1>

        <form @submit.prevent="submit">
          <!-- Personal Info -->
          <h2 class="text-lg font-semibold mb-2">Personal Information</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <Input label="Full Name" v-model="form.name" :error="form.errors.name" />
            <Input label="ID/Passport Number" v-model="form.id_number" :error="form.errors.id_number" />
            <Input label="Phone Number" v-model="form.phone" :error="form.errors.phone" />
            <Input label="Email Address" v-model="form.email" :error="form.errors.email" />
          </div>

          <!-- Employment -->
          <h2 class="text-lg font-semibold mb-2">Employment Details</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <Input label="Employer" v-model="form.employer" :error="form.errors.employer" />
            <Input label="Job Title" v-model="form.job_title" :error="form.errors.job_title" />
            <Input label="Monthly Income" v-model="form.income" type="number" :error="form.errors.income" />
            <Input label="Length of Employment" v-model="form.employment_length" :error="form.errors.employment_length" />
          </div>

          <!-- Rental History -->
          <h2 class="text-lg font-semibold mb-2">Rental History</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <Input label="Current Address" v-model="form.current_address" :error="form.errors.current_address" />
            <Input label="Landlord Contact" v-model="form.landlord_contact" :error="form.errors.landlord_contact" />
            <Input label="Reason for Moving" v-model="form.reason_for_moving" :error="form.errors.reason_for_moving" />
          </div>

          <!-- Other Info -->
          <h2 class="text-lg font-semibold mb-2">Additional Info</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <Input label="Number of Occupants" type="number" v-model="form.occupants" :error="form.errors.occupants" />
            <Input label="Do you have pets?" v-model="form.pets" :error="form.errors.pets" />
          </div>

          <!-- File Uploads -->
          <h2 class="text-lg font-semibold mb-2">Attachments</h2>
          <div class="mb-6 space-y-4">
            <input type="file" @change="handleFile('id_copy', $event)" />
            <input type="file" @change="handleFile('proof_of_income', $event)" />
          </div>

          <!-- Submit -->
          <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-sm hover:bg-green-700">
            Submit Application
          </button>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, useForm } from '@inertiajs/vue3'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  import Input from '@/Components/Input.vue'

  const form = useForm({
    name: '',
    id_number: '',
    phone: '',
    email: '',
    employer: '',
    job_title: '',
    income: '',
    employment_length: '',
    current_address: '',
    landlord_contact: '',
    reason_for_moving: '',
    occupants: 1,
    pets: '',
    id_copy: null,
    proof_of_income: null,
  })

  const handleFile = (field, event) => {
    form[field] = event.target.files[0]
  }

  const submit = () => {
    form.post(route('application.store'))
  }
  </script>
