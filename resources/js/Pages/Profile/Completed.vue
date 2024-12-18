<script lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <h2 class="text-lg font-medium text-gray-900">
                        登録が完了しました。🌖
                    </h2>
                    <!-- プロフィール画面へ戻る -->
                    <a
                        :href="route('profile.edit')"
                        class="mt-6 hover:bg-gray-200 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-300 bg-indigo-600focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        プロフィール画面へ戻る
                </a>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>