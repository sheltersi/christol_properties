<script setup>
import { ref, onMounted, watch, onUnmounted, computed } from 'vue';
import ApplicationLogo from '@/images/logo.png';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import SidebarLink from './SidebarLink.vue';
import { MenuIcon, XIcon } from 'lucide-vue-next';
import axios from 'axios';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';
import SidebarGroup from '@/Components/SidebarGroup.vue';
import NavLink from '@/Components/NavLink.vue';


const isSidebarCollapsed = ref(false);

const { props } = usePage();

const unreadCount = ref(props.unreadCount);

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

onMounted(() => {
    unreadCount.value = page.props.auth.user?.unread_notifications_count ?? 0
})

// ✅ function to refresh via an API
async function refreshUnreadCount() {
    try {
        const res = await axios.get('/admin/notifications/unread-count');
        unreadCount.value = res.data.count;
    } catch (error) {
        console.error('Failed to fetch unread count:', error);
    }
};

//call this after marking a notification as read
async function markAsRead(notificationId) {
    await axios.post(`/admin/notifications/${notificationId}/mark-as-read`)
    await refreshUnreadCount()
}

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
                    <h1 class="mt-2 font-bold text-lg bg-linear-to-r from-cyan-800 via-violet-500 to-emerald-500 bg-clip-text text-transparent"
                        v-if="!isSidebarCollapsed && showSidebarText">
                        Christo Property

                    </h1>
                </span>
                <button class="lg:hidden" @click="drawerOpen = false">
                    <XIcon class="h-6 w-6" />
                </button>
            </div>
            <nav class="mt-4 space-y-2 px-4">
                <SidebarLink v-if="!isAdmin" :to="route('tenant.dashboard')"
                    :active="route().current('tenant.dashboard')" label="Dashboard" :icon="['fas', 'house']"
                    :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarLink :to="route('notifications.index')" :active="route().current('notifications.index')"
                    label="Notifications" :icon="['fas', 'bell']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" />
                <SidebarLink v-if="isAdmin" :to="route('admin.dashboard')" :active="route().current('admin.dashboard')"
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
                    :icon="['fas', 'fa-address-card']" :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                <SidebarGroup v-if="!isAdmin" :icon="['fas', 'credit-card']" label="Payments"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="Pay Rent" :icon="['fas', 'money-bill-wave']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Payment History" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
                <!-- admin section -->
                <SidebarGroup v-if="isAdmin" :icon="['fas', 'fa-people-roof']" label="Tenants"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="View All Tenants" :icon="['fas', 'money-bill-wave']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Add New Tenant" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
                <SidebarGroup v-if="isAdmin" :icon="['fas', 'credit-card']" label="Payments"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="Pending Payment Confirmation" :icon="['fas', 'money-bill-wave']"
                        :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="View All Payments" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Missed Payments" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
                <SidebarGroup v-if="isAdmin" :icon="['fas', 'file-signature']" label="leases"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="View Active Leases" :icon="['fas', 'money-bill-wave']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Create / Upload New Lease" :icon="['fas', 'clock-rotate-left']"
                        :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Expiring Soon" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Expired" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
                <SidebarGroup v-if="isAdmin" :icon="['fas', 'receipt']" label="Receipts & Invoices"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="View Generated Receipts" :icon="['fas', 'money-bill-wave']"
                        :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="View Generated Invoice" :icon="['fas', 'money-bill-wave']"
                        :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Create & Send Invoice" :icon="['fas', 'clock-rotate-left']"
                        :collapsed="isSidebarCollapsed" :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Download PDFs" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
                <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                    label="Notices & Warnings" :icon="['fas', 'circle-exclamation']" :collapsed="isSidebarCollapsed"
                    :showText="showSidebarText" />
                <SidebarGroup v-if="isAdmin" :icon="['fas', 'gear']" label="Settings"
                    :isSidebarCollapsed="isSidebarCollapsed" :showSidebarText="showSidebarText">
                    <SidebarLink :to="route('tenant.payment.create')" :active="route().current('tenant.payment.create')"
                        label="Rent Amount" :icon="['fas', 'money-bill-wave']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Bank Details" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                    <SidebarLink :to="route('payments.history')" :active="route().current('payments.history')"
                        label="Download PDFs" :icon="['fas', 'clock-rotate-left']" :collapsed="isSidebarCollapsed"
                        :showText="showSidebarText" />
                </SidebarGroup>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col flex-1 transition-all duration-300"
            :class="isSidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
            <!-- Topbar -->
            <nav class="bg-white border-b shadow-sm sm:px-6 lg:px-8">
                <div class="flex items-center space-x-4 justify-between h-16">
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
                        <div class="relative me-4">
                            <NavLink :href="route('notifications.index')" class="">
                                <!-- <font-awesome-icon :icon="['fas', 'bell']" class="text-orange-300" /> -->
                                <span class="p-0 m-0">🔔</span>
                                <span v-if="unreadCount > 0"
                                    class="absolute -top-0.5 -right-0.5 bg-red-600 text-white rounded-full px-1 py-0 text-[10px] leading-none">
                                    {{ unreadCount }}
                                </span>
                            </NavLink>
                        </div>

                        <!-- User Dropdown -->
                        <Dropdown :align="right" width="48">
                            <template #trigger>
                                <button
                                    class="user-cicle inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
                                    <font-awesome-icon :icon="['fas', 'user']" class="mr-1 text-cyan-500" />
                                    {{ $page.props.auth.user?.name ?? 'unknown' }}
                                    <font-awesome-icon :icon="['fas', 'angle-down']" class="ms-2 " />
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
            <header v-if="$slots.header" class="bg-white shadow-sm">
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

.color {
    color: darkcyan
}
</style>
