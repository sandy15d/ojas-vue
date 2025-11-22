<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import UserEditLayout from '@/layouts/admin/UserEditLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    has_admin_access: boolean;
    has_sales_access: boolean;
    has_hr_access: boolean;
    has_cogs_access: boolean;
    has_budget_access: boolean;
    default_module: string | null;
    role_ids: number[];
}

interface Role {
    id: number;
    name: string;
}

interface Props {
    user: User;
    roles: Role[];
}

const props = defineProps<Props>();

// Create a reactive array for selected roles
const selectedRoles = ref<number[]>([...props.user.role_ids]);


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
];
</script>

<template>

    <Head :title="`Edit User - ${user.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <UserEditLayout :user-id="user.id" :user-name="user.name">
            <div class="space-y-6">
                <HeadingSmall title="Profile information"
                    description="Update the user's basic profile details and module access" />

                <Form :action="`/admin/users/${user.id}`" method="put"
                    #default="{ errors, processing, recentlySuccessful }" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" name="name" type="text" :default-value="user.name" placeholder="Full name"
                            required autocomplete="name" />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input id="email" name="email" type="email" :default-value="user.email"
                            placeholder="user@example.com" required autocomplete="email" />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="space-y-3">
                        <Label>Module access</Label>

                        <div class="space-y-3">
                            <div class="flex items-center space-x-2">
                                <Checkbox id="has_admin_access" name="has_admin_access" value="1"
                                    v-model="user.has_admin_access" />
                                <Label for="has_admin_access" class="cursor-pointer font-normal">
                                    Admin Module
                                </Label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="has_sales_access" name="has_sales_access" value="1"
                                    v-model="user.has_sales_access" />
                                <Label for="has_sales_access" class="cursor-pointer font-normal">
                                    Sales Module
                                </Label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="has_hr_access" name="has_hr_access" value="1"
                                    v-model="user.has_hr_access" />
                                <Label for="has_hr_access" class="cursor-pointer font-normal">
                                    HR Module
                                </Label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="has_cogs_access" name="has_cogs_access" value="1"
                                    v-model="user.has_cogs_access" />
                                <Label for="has_cogs_access" class="cursor-pointer font-normal">
                                    COGS Module
                                </Label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox id="has_budget_access" name="has_budget_access" value="1"
                                    v-model="user.has_budget_access" />
                                <Label for="has_budget_access" class="cursor-pointer font-normal">
                                    Budget Module
                                </Label>
                            </div>
                        </div>
                    </div>


                    <div class="grid gap-2">
                        <Label for="default_module">Default module</Label>

                        <select id="default_module" name="default_module" v-model="user.default_module"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            <option value="">Select default module</option>
                            <option value="admin">Admin</option>
                            <option value="sales">Sales</option>
                            <option value="hr">HR</option>
                            <option value="cogs">COGS</option>
                            <option value="budget">Budget</option>
                        </select>

                        <p class="text-xs text-muted-foreground">
                            The module the user will see when they log in
                        </p>
                    </div>


                    <div class="space-y-3">
                        <Label>Roles</Label>
                        <div class="space-y-3">
                            <div v-for="role in roles" :key="role.id" class="flex items-center space-x-2">
                                <Checkbox :id="`role_${role.id}`" :value="role.id"
                                    :checked="selectedRoles.includes(role.id)" @update:checked="(checked) => {
                                        if (checked) {
                                            if (!selectedRoles.value.includes(role.id)) {
                                                selectedRoles.value.push(role.id);
                                            }
                                        } else {
                                            selectedRoles.value = selectedRoles.value.filter(id => id !== role.id);
                                        }
                                    }" />
                                <Label :for="`role_${role.id}`" class="cursor-pointer font-normal capitalize">
                                    {{ role.name }}
                                </Label>
                            </div>
                            <!-- Hidden inputs for form submission -->
                            <input v-for="roleId in selectedRoles" :key="`hidden_role_${roleId}`" type="hidden"
                                name="roles[]" :value="roleId" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button type="submit" :disabled="processing">
                            Save changes
                        </Button>

                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
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
