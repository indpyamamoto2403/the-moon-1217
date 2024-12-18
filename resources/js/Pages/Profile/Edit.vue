<script setup lang ="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from '@/Organisms/Profile/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { userProfile } from './interface';

const props = defineProps<{
    profile: userProfile;
}>();

</script>

<template>
    <Head title="Profile" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdateProfileInformationForm
                        :profile="profile"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
