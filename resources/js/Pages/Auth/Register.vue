<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />
              <div class="py-4 bg-slate-800 text-white font-extrabold text-2xl text-center mb-4">
            Sign Into Your Account
        </div>
        <div class="px-6 py-4">

        <form @submit.prevent="submit">
            <!-- First Name -->
            <div>
                <InputLabel for="first_name" value="First Name(s)" />
                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required
                    autofocus autocomplete="given-name" />
                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <!-- Last Name -->
            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />
                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required
                    autocomplete="family-name" />
                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Already registered ?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register now
                </PrimaryButton>
            </div>
        </form>
        </div>
    </GuestLayout>
</template>
