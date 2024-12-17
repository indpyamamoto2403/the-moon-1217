<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="個人情報登録" />

    <AuthenticatedLayout>
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1 class="text-2xl font-semibold text-gray-800">welcome to the moon 🌙 !</h1>
            </div>
            <div class="dashboard-body">
                <p class="text-lg text-gray-600">You're logged in!</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.dashboard-container{
    @apply flex flex-col justify-center items-center pt-6 space-y-6;
}

.dashboard-header{
    @apply text-center;
}

.dashboard-body{
    @apply bg-white p-6 rounded-lg shadow-md min-w-[700px];
}
</style>
