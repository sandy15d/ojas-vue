<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import UserEditLayout from '@/layouts/admin/UserEditLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';

interface Permission {
    id: number;
    name: string;
}

interface User {
    id: number;
    name: string;
    permission_ids: number[];
}

interface Props {
    user: User;
    permissions: Permission[];
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
        title: 'Permissions',
        href: `/admin/users/${props.user.id}/permissions`,
    },
];

const selectedPermissions = ref<number[]>([...props.user.permission_ids]);

const togglePermission = (permissionId: number) => {
    const index = selectedPermissions.value.indexOf(permissionId);
    if (index > -1) {
        selectedPermissions.value.splice(index, 1);
    } else {
        selectedPermissions.value.push(permissionId);
    }
};
</script>

<template>
    <Head :title="`Permissions - ${user.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <UserEditLayout :user-id="user.id" :user-name="user.name">
            <div class="space-y-6">
                <HeadingSmall
                    title="Permissions"
                    description="Grant or revoke specific permissions for this user"
                />

                <Form
                    :action="`/admin/users/${user.id}/permissions`"
                    method="put"
                    #default="{ errors, processing, recentlySuccessful }"
                    class="space-y-6"
                >
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div
                            v-for="permission in permissions"
                            :key="permission.id"
                            class="flex items-center space-x-2"
                        >
                            <Checkbox
                                :id="`permission-${permission.id}`"
                                :name="`permissions[]`"
                                :value="permission.id"
                                :checked="selectedPermissions.includes(permission.id)"
                                @update:checked="togglePermission(permission.id)"
                            />
                            <Label :for="`permission-${permission.id}`" class="cursor-pointer font-normal text-sm">
                                {{ permission.name }}
                            </Label>
                        </div>
                    </div>
                    <InputError :message="errors.permissions" />

                    <div class="flex items-center gap-4">
                        <Button type="submit" :disabled="processing">
                            Save permissions
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>
        </UserEditLayout>
    </AppLayout>
</template>
