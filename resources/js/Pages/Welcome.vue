<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <header class="w-full min-h-screen flex flex-col items-center justify-center p-4 space-y-4 bg-slate-300">
        <div class="welcome-container">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Welcome to a new version of The Moon!🌙</h1>
                <p class="mt-4 text-lg">using Laravel v{{ laravelVersion }} and PHP v{{ phpVersion }}</p>
            </div>
            <nav v-if="canLogin" class="-mx-3 flex justify-between">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="bg-yellow-300 hover:bg-yellow-400 translate-x-2rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                register-profile
                </Link>
                <template v-else>
                    <div class="flex space-x-4">
                        <Link
                            :href="route('login')"
                            class="bg-green-300 hover:bg-green-400 hover:-translate-y-2 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="bg-red-300 hover:bg-red-400 hover:translate-x-2 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </Link>
                    </div>
                </template>
            </nav>
        </div>
    </header>
</template>

<style scoped>
.welcome-container {
    @apply bg-white p-4 rounded-lg shadow-md flex flex-col items-center cursor-pointer;
}
</style>
