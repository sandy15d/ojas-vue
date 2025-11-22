<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import UserEditLayout from '@/layouts/admin/UserEditLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';

interface User {
    id: number;
    name: string;
}

interface Props {
    user: User;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin/dashboard',
    },
    {
        title: 'Users',
        href: '/admin/users',
    },
    {
        title: props.user.name,
        href: `/admin/users/${props.user.id}/edit`,
    },
    {
        title: 'Password',
        href: `/admin/users/${props.user.id}/password`,
    },
];
</script>

<template>
    <Head :title="`Change Password - ${user.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <UserEditLayout :user-id="user.id" :user-name="user.name">
            <div class="space-y-6">
                <HeadingSmall
                    title="Change password"
                    description="Update the user's password"
                />

                <Form
                    :action="`/admin/users/${user.id}/password`"
                    method="put"
                    reset-on-success
                    #default="{ errors, processing, recentlySuccessful }"
                    class="space-y-6"
                >
                    <div class="grid gap-2">
                        <Label for="password">New password</Label>
                        <Input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirm new password</Label>
                        <Input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                        />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button type="submit" :disabled="processing">
                            Update password
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                Password updated.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>
        </UserEditLayout>
    </AppLayout>
</template>
