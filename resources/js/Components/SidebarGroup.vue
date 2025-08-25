<!-- resources/js/Components/SidebarGroup.vue -->
<script setup>
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    icon: Array,
    label: String,
    isSidebarCollapsed: Boolean,
    showSidebarText: Boolean,
    defaultOpen: Boolean
});

const isOpen = ref(props.defaultOpen ?? false);
</script>

<template>
    <div>
        <!-- Parent menu -->
        <button
            @click="isOpen = !isOpen"
            class="flex items-center w-full px-4 py-2 text-gray-700 rounded hover:bg-gray-200 transition"
        >
            <FontAwesomeIcon :icon="icon" class="ml-2 mr-3 icons-color" />
            <span v-if="!isSidebarCollapsed && showSidebarText" class="flex-1 text-left">{{ label }}</span>
            <FontAwesomeIcon
                :icon="isOpen ? ['fas', 'chevron-up'] : ['fas', 'chevron-down']"
                v-if="!isSidebarCollapsed && showSidebarText"
            />
        </button>

        <!-- Child links slot -->
        <transition name="fade">
            <div v-show="isOpen && !isSidebarCollapsed" class="ml-10 mt-1 space-y-1">
                <slot />
            </div>
        </transition>
    </div>
</template>

<style scoped>
.icons-color{
    color:darkcyan
}
</style>
