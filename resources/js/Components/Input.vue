<template>
    <div>
      <label :for="name" class="block text-sm font-medium text-gray-700 mb-1">
        {{ label }}
      </label>
      <input
        :id="name"
        :name="name"
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="block w-full rounded-md shadow-xs border-gray-300 focus:ring-3 focus:ring-opacity-50"
        :class="{ 'border-red-500': error }"
      />
      <p v-if="error" class="text-red-600 text-sm mt-1">{{ error }}</p>
    </div>
  </template>

  <script setup>
  defineProps({
    modelValue: [String, Number],
    label: String,
    name: String,
    error: String,
    type: {
      type: String,
      default: 'text',
    },
  })
  defineEmits(['update:modelValue'])
  </script>
