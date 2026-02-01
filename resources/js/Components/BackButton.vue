<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
})
</script>


    <template>
        <Link
             :href="href"
            class="inline-flex bg-cyan-950 items-center rounded-md border border-transparent  px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
        >
            <slot />
    </Link>
    </template>

    <style scoped>
    button{
        background-color: black;
    }
    </style>
