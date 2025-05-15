<template>
    <a :href="to" :method="method" :as="as" class="side-link block px-4 py-2 rounded hover:bg-gray-700"
        :class="{ 'bg-gray-200 font-semibold text-blue-700': active }">
        {{ label }}
    </a>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    to: String,
    label: String,
    active: Boolean,
    method: {
        type: String,
        default: 'get'
    },
    as: {
        type: String,
        default: 'a'
    }
});
</script>

<style scoped>
.sidebar-link {
    @apply block px-4 py-2 rounded text-gray-700 hover:bg-gray-100 transition;
}
</style>
