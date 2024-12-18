<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { userProfile } from '../../Pages/Profile/interface.ts';
import { fields } from '@/Data/Profile/forms.ts';
const props = defineProps<{
    profile: userProfile;
}>();

console.log(props.profile.company_name);

const user = usePage().props.auth.user;

const form = useForm<userProfile>({
    user_id: user.id,
    name: props.profile.name,
    email: props.profile.email,
    company_name: props.profile.company_name,
    department: props.profile.department,
    position: props.profile.position,
    zipCode: props.profile.zipCode,
    address: props.profile.address,
    company_url: props.profile.company_url,
    company_overview: props.profile.company_overview,
});

const submitForm = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
        },
        onError: () => {
        }
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                プロフィール登録
            </h2>
        </header>

        <form
            @submit.prevent="submitForm"
            class="mt-6 space-y-6"
        >
            <!-- fieldsからフォームフィールドを生成 -->
            <div v-for="field in fields" :key="field.id">
                <InputLabel :for="field.id" :value="field.label" />
                <TextInput
                    :id="field.id"
                    :type="field.type"
                    :class="'mt-1 block w-full'"
                    v-model="form[field.model]"
                    :required="field.required"
                    :autocomplete="field.autocomplete"
                    :pattern="field.pattern"
                    :placeholder="field.placeholder"
                />
                <InputError class="mt-2" :message="form.errors[field.model]" />
            </div>


            <div>
                <InputLabel for="companyOverview" value="会社概要" />
                <textarea
                    id="companyOverview"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.company_overview"
                    rows="4"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.company_overview" />
            </div>

            
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">登録</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        保存されました。
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>