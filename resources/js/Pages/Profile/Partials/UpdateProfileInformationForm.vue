<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { userProfile } from '../interface.ts';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm<userProfile>({
    userId: user.id,
    name: '',
    email: '',
    companyName: '',
    department: '',
    position: '',
    zipCode: '',
    address: '',
    companyUrl: '',
    companyOverview: '',
});
const submitForm = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Add any success handling logic
        },
        onError: () => {
            // Optional: Add any error handling logic
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
            <div>
                <InputLabel for="name" value="名前" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="メールアドレス" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="companyName" value="会社名" />
                <TextInput
                    id="companyName"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.companyName"
                    autocomplete="organization"
                />
                <InputError class="mt-2" :message="form.errors.companyName" />
            </div>

            <div>
                <InputLabel for="department" value="部署" />
                <TextInput
                    id="department"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.department"
                />
                <InputError class="mt-2" :message="form.errors.department" />
            </div>

            <div>
                <InputLabel for="post" value="役職" />
                <TextInput
                    id="post"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.position"
                />
                <InputError class="mt-2" :message="form.errors.position" />
            </div>  

            <div>
                <InputLabel for="zipCode" value="郵便番号" />
                <TextInput
                    id="zipCode"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.zipCode"
                    pattern="[0-9]{3}-[0-9]{4}"
                    placeholder="例: 123-4567"
                />
                <InputError class="mt-2" :message="form.errors.zipCode" />
            </div>

            <div>
                <InputLabel for="address" value="住所" />
                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                />
                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="companyUrl" value="会社URL" />
                <TextInput
                    id="companyUrl"
                    type="url"
                    class="mt-1 block w-full"
                    v-model="form.companyUrl"
                    placeholder="https://example.com"
                />
                <InputError class="mt-2" :message="form.errors.companyUrl" />
            </div>

            <div>
                <InputLabel for="companyOverview" value="会社概要" />
                <textarea
                    id="companyOverview"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.companyOverview"
                    rows="4"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.companyOverview" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    メールアドレスが確認されていません。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        確認メールを再送するにはここをクリック
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    新しい確認リンクがメールアドレスに送信されました。
                </div>
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