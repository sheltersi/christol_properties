<template>
     <div class="md:ms-[100px] ms-[20px] mt-[15px]">
    <h1 class="text-2xl font-bold text-blue-950">Contact Us</h1>
    <hr class="contact-hr w-20 mb-6">
    <p class=" pb-4">From viewing to moving — we’re with you all the way.</p>
    </div>

    <div class="mb-6 max-w-7xl md:mx-auto md:ps-6 flex flex-col md:flex-row gap-6 mx-[20px]">
       <div class="bg-white w-full md:w-1/3 p-6 rounded shadow">
        <h1>Call Us: <br>
          <font-awesome-icon :icon="['fas', 'phone']" class="me-2 text-green-500" />
          +27 63 326 4684
        </h1>
       </div>
      <div class="bg-white w-full md:w-1/3 p-6 rounded shadow">
        <h1>Email Us: <br>
          <font-awesome-icon :icon="['fas', 'envelope']" class="me-2 text-blue-500" />
          info@christolproperty.co.za
        </h1>
       </div>
        <div class="bg-white w-full md:w-1/3 p-6 rounded shadow">
          <h1>Our Location:</h1>
            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2 text-red-500" />
            Bramley Park, Johannesburg, South Africa
       </div>
    </div>

  <div class="bg-blue-200 px-4 py-10">

    <div class="md:ms-[95px]">
    <h1 class="text-2xl font-bold text-blue-950">Get In Touch</h1>
    <hr class="contact-hr w-20 mb-6">
    <p class="text-gray-600 mb-[25px]">Reach out during office hours — or drop us an email anytime.</p>
    </div>
    <!-- Flex container for cards -->
    <div class="max-w-7xl mx-auto md:ps-6 flex flex-col md:flex-row gap-6">

            <!-- Contact Info Card -->
      <div class="bg-[darkcyan] w-full md:w-1/3 p-6 rounded shadow">
      <!-- <div class="bg-blue-800 max-w-xl mx-auto p-6 rounded shadow"> -->
        <h1 class="text-white text-xl font-bold">Contact Information</h1>
        <p class="text-white text-l ps-4 pt-4"> <font-awesome-icon :icon="['fas', 'phone']" class="me-2" /> +27 63 326
          4684</p>
        <p class="text-white text-l ps-4 pt-1"> <font-awesome-icon :icon="['fab', 'whatsapp']" class="me-2" /> +27 63
          326 4684</p>
        <p class="text-white text-l ps-4 pt-1"> <font-awesome-icon :icon="['fas', 'envelope']" class="me-2" />
          info@christolproperty.co.za</p>

        <p class="text-white text-l ps-4 pt-4">Trading Hours</p>
        <ul>
          <li class="text-white ps-6 pt-2">Monday - Friday: 09:00 - 17:00</li>
          <li class="text-white ps-6 pt-1">Saturday: 09:00 - 14:00</li>
          <li class="text-white ps-6 pt-1">Sunday: Closed</li>
          <li class="text-white ps-6 pt-1">Public Holidays: Closed</li>
        </ul>

        <p class="text-white ps-6 pt-4">Let’s talk. We’d love to hear from you. We’re here to help — reach out to us
          anytime!</p>

      </div>
       <!-- Contact Form Card -->
      <div class="w-full md:w-1/2 bg-white p-6 rounded shadow">
      <!-- <div class="max-w-2xl mx-auto my-10 bg-white p-6 rounded shadow"> -->
        <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
        <form @submit.prevent="submitForm" class="space-y-4">
             <p v-if="successMessage" class="text-green-800 max-w-6xl mx-auto bg-green-300 py-[15px] ps-[10px] mt-2">{{ successMessage }}</p>
          <div>
            <label class="block text-sm font-medium">Name</label>
            <input v-model="form.name" type="text" class="input" placeholder="Your name" />
            <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium">Email</label>
            <input v-model="form.email" type="email" class="input" placeholder="Your email" />
            <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium">Subject</label>
            <input v-model="form.subject" type="text" class="input" placeholder="Subject" />
            <p v-if="errors.subject" class="text-red-500 text-sm">{{ errors.subject }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium">Message</label>
            <textarea v-model="form.message" rows="4" class="input" placeholder="Your message"></textarea>
            <p v-if="errors.message" class="text-red-500 text-sm">{{ errors.message }}</p>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="bg-[darkcyan] text-white px-4 py-2 rounded hover:bg-blue-700"
              :disabled="processing">
              {{ processing ? 'Sending...' : 'Send Message' }}
            </button>
          </div>
        </form>

        <!-- <p v-if="successMessage" class="text-green-600 mt-4">
          {{ successMessage }}
        </p> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const errors = ref({})
const processing = ref(false)
const successMessage = ref('')

function submitForm() {
  processing.value = true
  errors.value = {}
  successMessage.value = ''

  router.post(route('contact.send'), form.value, {
    onSuccess: () => {
      successMessage.value = 'Message sent successfully!'
      form.value = { name: '', email: '', subject: '', message: '' }
    },
    onError: (err) => {
      errors.value = err
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<style scoped>
.input {
  @apply w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-300;
}

.contact-hr{
    border: none;
  height: 6px;
  background-color: darkcyan; /* Use a contrasting color */
  margin: 1rem 0;
}
</style>
