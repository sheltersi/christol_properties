<!-- /resources/js/Components/ReasonModal.vue -->
<template>
    <teleport to="body">
      <div v-if="modelValue" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
          <h2 class="text-lg font-semibold mb-4">{{ title }}</h2>
          <p class="mb-2 text-sm">{{ description }}</p>
          <textarea
            v-model="reason"
            class="w-full border rounded px-3 py-2 mb-4"
            rows="4"
            :placeholder="placeholder"
          ></textarea>
          <div class="flex justify-end space-x-2">
            <button
              @click="$emit('update:modelValue', false)"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
            >
              Cancel
            </button>
            <button
              @click="submit"
              :disabled="!reason.trim()"
              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            >
              {{ submitLabel }}
            </button>
          </div>
        </div>
      </div>
    </teleport>
  </template>

  <script setup>
  import { ref, watch } from 'vue'

  const props = defineProps({
    modelValue: Boolean,
    title: String,
    description: String,
    placeholder: {
      type: String,
      default: 'Enter reason here...',
    },
    submitLabel: {
      type: String,
      default: 'Submit',
    },
  })

  const emit = defineEmits(['update:modelValue', 'submit'])

  const reason = ref('')

  watch(
    () => props.modelValue,
    (val) => {
      if (!val) reason.value = ''
    }
  )

  const submit = () => {
    emit('submit', reason.value)
    emit('update:modelValue', false)
  }
  </script>
