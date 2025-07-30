<script setup>
import { ref, onMounted, watch, onUnmounted, computed } from 'vue';
import ApplicationLogo from '@/images/logo.png';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import SidebarLink from './SidebarLink.vue';
import { MenuIcon, XIcon } from 'lucide-vue-next';
import axios from 'axios';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';

const isSidebarCollapsed = ref(false);

const unreadCount = ref(0);

const notificationCount = ref(0)


const drawerOpen = ref(false);
const page = usePage();

const isAdmin = computed(() => page.props.auth.user?.role === 'admin');
const showSidebarText = ref(true); // controls when to show text

watch(isSidebarCollapsed, (collapsed) => {
    if (collapsed) {
        // Immediately hide text when collapsing
        showSidebarText.value = false;
    } else {
        // Delay showing text until after transition ends
        setTimeout(() => {
            showSidebarText.value = true;
        }, 100); // Match this with your sidebar's transition duration
    }
});

// ✅ Watch for flash messages
watch(() => page.props.flash, (flash) => {
    if (flash.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: flash.success,
        });
    }

    if (flash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: flash.error,
        });
    }
}, { immediate: true }); // Optional: run immediately on mount

// ✅ Unread notification count
onMounted(async () => {
    try {
        const res = await axios.get('/admin/notifications/unread-count');
        unreadCount.value = res.data.count;
    } catch (error) {
        console.error('Failed to fetch unread count:', error);
    }
});

</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Mobile Sidebar Drawer -->
        <transition name="fade">
            <div v-if="drawerOpen" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
                @click="drawerOpen = false"></div>
        </transition>
        <aside
            class="fixed top-0 left-0 z-50 h-full bg-white border-r shadow-lg transform lg:translate-x-0 transition-all duration-300 ease-in-out"
            :class="{
                '-translate-x-full': !drawerOpen && !isSidebarCollapsed,
                'w-64': !isSidebarCollapsed,
                'w-20': isSidebarCollapsed
            }">
            <div class="flex items-center justify-between p-4 border-b">
                <span class="flex"><img :src="ApplicationLogo" alt="Logo" class="h-8" />
                    <h1 class="mt-2 font-bold text-lg bg-gradient-to-r from-cyan-800 via-violet-500 to-emerald-500 bg-clip-text text-transparent" v-if="!isSidebarCollapsed && showSidebarText">
                      Christo Property

                    </h1>
                </span>
                <button class="lg:hidden" @click="drawerOpen = false">
                    <XIcon class="h-6 w-6" />
                </button>
            </div>
            <nav class="mt-4 space-y-2 px-4">
                <SidebarLink v-if="!isAdmin" :to="route('dashboard')" :active="route().current('dashboard')"
                    label="Dashboard" :icon="['fas', 'house']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" />
                <SidebarLink v-if="!isAdmin" :to="route('appointments.index')"
                    :active="route().current('appointments.index')" label="My Lease" :icon="['fas', 'file-signature']"
                    :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarLink v-if="!isAdmin" :to="route('application.create')"
                    :active="route().current('application.create')" label="Payments" :icon="['fas', 'credit-card']"
                    :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarLink v-if="!isAdmin" :to="route('all-appointments.index')"
                    :active="route().current('all-appointments.index')" label="Receipts" :icon="['fas', 'receipt']"
                    :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarLink v-if="!isAdmin" :to="route('applications.index')"
                    :active="route().current('applications.index')" label="Notices"
                    :icon="['fas', 'circle-exclamation']" :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarLink v-if="!isAdmin" :to="route('all-appointments.index')" label="Maintenance"
                    :icon="['fas', 'fa-screwdriver-wrench']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" />
                    <!-- Contact & Account -->
                      <SidebarLink v-if="!isAdmin" :to="route('all-appointments.index')" label="Contact & Account"
                    :icon="['fas', 'fa-address-card']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" />
                <!-- <SidebarLink v-if="!isAdmin" :to="route('profile.edit')" label="Profile"
                    :icon="['fas', 'user']" :collapsed="isSidebarCollapsed" :showText="showSidebarText" /> -->
                <!-- <SidebarLink v-if="!isAdmin" :to="route('logout')" label="Logout"
                    :icon="['fas', 'fa-right-from-bracket']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" /> -->

            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col flex-1 transition-all duration-300"
            :class="isSidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
            <!-- Topbar -->
            <nav class="bg-white border-b shadow sm:px-6 lg:px-8">
                <div class="flex items-center space-x-4 justify-between h-16">
                    <!-- <div class="flex items-center space-x-4"> -->
                    <button class="lg:hidden" @click="drawerOpen = true">
                        <MenuIcon class="h-6 w-6 text-gray-700" />
                    </button>

                    <!-- ✅ Desktop Sidebar Toggle -->
                    <button class="hidden lg:block" @click="isSidebarCollapsed = !isSidebarCollapsed">
                        <MenuIcon class="h-6 w-6 text-gray-700" />
                    </button>

                    <!-- <Link :href="route('dashboard')">
                        <img :src="ApplicationLogo" alt="Logo" class="h-9 w-auto" />
                        </Link>
                        <NavLink v-if="!isAdmin" :href="route('dashboard')" :active="route().current('dashboard')">Home
                        </NavLink>
                        <NavLink v-if="!isAdmin" :href="route('appointments.index')"
                            :active="route().current('appointments.index')">contact
                        </NavLink> -->
                    <!-- </div> -->

                    <div class="inline-flex">
                        <h1 class="me-4">
                            <font-awesome-icon :icon="['fas', 'bell']" />
                            notifications
                        </h1>

                        <!-- User Dropdown -->
                        <Dropdown :align="right" width="48">
                            <template #trigger>
                                <button
                                    class="user-cicle inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
                                    <font-awesome-icon :icon="['fas', 'user']" class="mr-2 text-gray-500" />
                                    {{ $page.props.auth.user?.first_name }}
                                    <font-awesome-icon :icon="['fas', 'angle-down']" class="ms-2" />
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </nav>

            <!-- Header Slot -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="">
                <div class="">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
.sidebar-link {
    @apply block px-4 py-2 rounded text-gray-700 hover:bg-gray-200 transition;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.color{
    color:darkcyan
}
</style>
