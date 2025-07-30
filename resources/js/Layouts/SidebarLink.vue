<template>
    <a :href="to" :method="method" :as="as" class="side-link block px-4 py-2 rounded hover:bg-gray-700 hover:text-white"
        :class="{ 'bg-gray-200 font-semibold text-blue-700': active }">
         <font-awesome-icon v-if="icon" :icon="icon" class="icons-color w-8" />
            <span v-if="showText" class="text-sm text-gray-700">{{ label }}</span>
    </a>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

defineProps({
    to: String,
    label: String,
    active: Boolean,
    icon: [Array, String],
     collapsed: Boolean,
     showText: Boolean,
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
.icons-color{
    color:darkcyan
}
</style>
