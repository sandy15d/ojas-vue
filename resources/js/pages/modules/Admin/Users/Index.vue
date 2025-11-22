<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import { MoreHorizontal, Pencil, Plus, Trash, Search, Download, Printer, X, Filter } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

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
    permissions_count: number;
    roles: string[];
    created_at: string;
}

interface Role {
    id: number;
    name: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedUsers {
    data: User[];
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
    links: PaginationLink[];
}

interface Props {
    users: PaginatedUsers;
    roles: Role[];
    filters: {
        search?: string;
        role?: string;
        module?: string;
        per_page?: number;
    };
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
];

// Filters
const search = ref(props.filters.search || '');
const selectedRole = ref(props.filters.role?.toString() || 'all');
const selectedModule = ref(props.filters.module || 'all');
const perPage = ref(props.filters.per_page?.toString() || '15');

// Update filters with debounce for search
const updateFilters = debounce(() => {
    router.get('/admin/users', {
        search: search.value || undefined,
        role: (selectedRole.value && selectedRole.value !== 'all') ? selectedRole.value : undefined,
        module: (selectedModule.value && selectedModule.value !== 'all') ? selectedModule.value : undefined,
        per_page: perPage.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
}, 300);

watch([search, selectedRole, selectedModule, perPage], () => {
    updateFilters();
});

const clearFilters = () => {
    search.value = '';
    selectedRole.value = 'all';
    selectedModule.value = 'all';
    perPage.value = '15';
};

const hasActiveFilters = () => {
    return search.value || (selectedRole.value && selectedRole.value !== 'all') || (selectedModule.value && selectedModule.value !== 'all');
};

const getModuleBadges = (user: User) => {
    const modules = [];
    if (user.has_admin_access) modules.push({ name: 'Admin', variant: 'default' });
    if (user.has_sales_access) modules.push({ name: 'Sales', variant: 'secondary' });
    if (user.has_hr_access) modules.push({ name: 'HR', variant: 'secondary' });
    if (user.has_cogs_access) modules.push({ name: 'COGS', variant: 'secondary' });
    if (user.has_budget_access) modules.push({ name: 'Budget', variant: 'secondary' });
    return modules;
};

const deleteUser = (user: User) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        router.delete(`/admin/users/${user.id}`, {
            preserveScroll: true,
        });
    }
};

// Export functionality
const exportUsers = () => {
    const params = new URLSearchParams();
    if (search.value) params.append('search', search.value);
    if (selectedRole.value && selectedRole.value !== 'all') params.append('role', selectedRole.value);
    if (selectedModule.value && selectedModule.value !== 'all') params.append('module', selectedModule.value);

    window.location.href = `/admin/users-export?${params.toString()}`;
};

// Print functionality
const printTable = () => {
    window.print();
};

// Create User Modal State
const showCreateModal = ref(false);
const createForm = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    has_admin_access: false,
    has_sales_access: false,
    has_hr_access: false,
    has_cogs_access: false,
    has_budget_access: false,
    default_module: '',
    roles: [] as number[],
});
const createErrors = ref<Record<string, string>>({});
const creating = ref(false);

const createUser = () => {
    creating.value = true;
    createErrors.value = {};

    router.post('/admin/users', createForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showCreateModal.value = false;
            createForm.value = {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_admin_access: false,
                has_sales_access: false,
                has_hr_access: false,
                has_cogs_access: false,
                has_budget_access: false,
                default_module: '',
                roles: [],
            };
        },
        onError: (errors) => {
            createErrors.value = errors as Record<string, string>;
        },
        onFinish: () => {
            creating.value = false;
        },
    });
};
</script>

<template>
    <Head title="Users Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Users Management</h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Manage users, their module access, and permissions
                    </p>
                </div>

                <!-- Create User Dialog -->
                <Dialog v-model:open="showCreateModal">
                    <DialogTrigger as-child>
                        <Button class="no-print">
                            <Plus class="mr-2 size-4" />
                            Add User
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="max-w-md" :static="true">
                        <DialogHeader>
                            <DialogTitle>Create New User</DialogTitle>
                            <DialogDescription>
                                Add a new user to the system
                            </DialogDescription>
                        </DialogHeader>

                        <form @submit.prevent="createUser" class="space-y-4">
                            <div class="space-y-2">
                                <Label for="create_name">Name</Label>
                                <Input
                                    id="create_name"
                                    v-model="createForm.name"
                                    placeholder="Full name"
                                    required
                                />
                                <InputError :message="createErrors.name" />
                            </div>

                            <div class="space-y-2">
                                <Label for="create_email">Email</Label>
                                <Input
                                    id="create_email"
                                    v-model="createForm.email"
                                    type="email"
                                    placeholder="user@example.com"
                                    required
                                />
                                <InputError :message="createErrors.email" />
                            </div>

                            <div class="space-y-2">
                                <Label for="create_password">Password</Label>
                                <Input
                                    id="create_password"
                                    v-model="createForm.password"
                                    type="password"
                                    placeholder="••••••••"
                                    required
                                />
                                <InputError :message="createErrors.password" />
                            </div>

                            <div class="space-y-2">
                                <Label for="create_password_confirmation">Confirm Password</Label>
                                <Input
                                    id="create_password_confirmation"
                                    v-model="createForm.password_confirmation"
                                    type="password"
                                    placeholder="••••••••"
                                    required
                                />
                            </div>

                            <div class="space-y-2">
                                <Label>Module Access</Label>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="create_admin"
                                            v-model:checked="createForm.has_admin_access"
                                        />
                                        <Label for="create_admin" class="cursor-pointer font-normal">Admin</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="create_sales"
                                            v-model:checked="createForm.has_sales_access"
                                        />
                                        <Label for="create_sales" class="cursor-pointer font-normal">Sales</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="create_hr"
                                            v-model:checked="createForm.has_hr_access"
                                        />
                                        <Label for="create_hr" class="cursor-pointer font-normal">HR</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="create_cogs"
                                            v-model:checked="createForm.has_cogs_access"
                                        />
                                        <Label for="create_cogs" class="cursor-pointer font-normal">COGS</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="create_budget"
                                            v-model:checked="createForm.has_budget_access"
                                        />
                                        <Label for="create_budget" class="cursor-pointer font-normal">Budget</Label>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="create_default_module">Default Module</Label>
                                <select
                                    id="create_default_module"
                                    v-model="createForm.default_module"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                                    <option value="">Select module</option>
                                    <option value="admin">Admin</option>
                                    <option value="sales">Sales</option>
                                    <option value="hr">HR</option>
                                    <option value="cogs">COGS</option>
                                    <option value="budget">Budget</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <Label>Roles</Label>
                                <div class="space-y-2">
                                    <div v-for="role in roles" :key="role.id" class="flex items-center space-x-2">
                                        <Checkbox
                                            :id="`create_role_${role.id}`"
                                            :checked="createForm.roles.includes(role.id)"
                                            @update:checked="(checked) => {
                                                if (checked) {
                                                    createForm.roles.push(role.id);
                                                } else {
                                                    createForm.roles = createForm.roles.filter(r => r !== role.id);
                                                }
                                            }"
                                        />
                                        <Label :for="`create_role_${role.id}`" class="cursor-pointer font-normal capitalize">
                                            {{ role.name }}
                                        </Label>
                                    </div>
                                </div>
                            </div>

                            <DialogFooter>
                                <Button type="submit" :disabled="creating">
                                    {{ creating ? 'Creating...' : 'Create User' }}
                                </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>

            <!-- Filters and Actions Bar -->
            <div class="no-print flex flex-col gap-3 rounded-lg border border-sidebar-border/70 bg-white p-4 dark:border-sidebar-border dark:bg-neutral-900">
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <div class="relative flex-1 min-w-[200px]">
                        <Search class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-neutral-400" />
                        <Input
                            v-model="search"
                            placeholder="Search by name or email..."
                            class="pl-9"
                        />
                    </div>

                    <!-- Role Filter -->
                    <Select v-model="selectedRole">
                        <SelectTrigger class="w-[180px]">
                            <Filter class="mr-2 size-4" />
                            <SelectValue placeholder="Filter by role" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="all">All Roles</SelectItem>
                                <SelectItem v-for="role in roles" :key="role.id" :value="role.id.toString()">
                                    {{ role.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <!-- Module Filter -->
                    <Select v-model="selectedModule">
                        <SelectTrigger class="w-[180px]">
                            <Filter class="mr-2 size-4" />
                            <SelectValue placeholder="Filter by module" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="all">All Modules</SelectItem>
                                <SelectItem value="admin">Admin</SelectItem>
                                <SelectItem value="sales">Sales</SelectItem>
                                <SelectItem value="hr">HR</SelectItem>
                                <SelectItem value="cogs">COGS</SelectItem>
                                <SelectItem value="budget">Budget</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <!-- Clear Filters -->
                    <Button
                        v-if="hasActiveFilters()"
                        variant="ghost"
                        size="sm"
                        @click="clearFilters"
                    >
                        <X class="mr-2 size-4" />
                        Clear
                    </Button>

                    <div class="ml-auto flex items-center gap-2">
                        <!-- Export Button -->
                        <Button variant="outline" size="sm" @click="exportUsers">
                            <Download class="mr-2 size-4" />
                            Export CSV
                        </Button>

                        <!-- Print Button -->
                        <Button variant="outline" size="sm" @click="printTable">
                            <Printer class="mr-2 size-4" />
                            Print
                        </Button>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="flex items-center justify-between text-sm text-neutral-600 dark:text-neutral-400">
                    <div>
                        Showing {{ users.data.length }} of {{ users.total }} users
                        <span v-if="hasActiveFilters()" class="text-neutral-500">(filtered)</span>
                    </div>

                    <!-- Per Page Selector -->
                    <div class="flex items-center gap-2">
                        <span class="text-sm">Show:</span>
                        <Select v-model="perPage">
                            <SelectTrigger class="h-8 w-[80px]">
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="10">10</SelectItem>
                                    <SelectItem value="15">15</SelectItem>
                                    <SelectItem value="25">25</SelectItem>
                                    <SelectItem value="50">50</SelectItem>
                                    <SelectItem value="100">100</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </div>

            <!-- Compact Users Table -->
            <div class="overflow-hidden rounded-lg border border-sidebar-border/70 bg-white dark:border-sidebar-border dark:bg-neutral-900">
                <div class="overflow-x-auto">
                    <Table>
                        <TableHeader>
                            <TableRow class="bg-neutral-50 dark:bg-neutral-800/50">
                                <TableHead class="h-9 text-xs font-semibold">Name</TableHead>
                                <TableHead class="h-9 text-xs font-semibold">Email</TableHead>
                                <TableHead class="h-9 text-xs font-semibold">Roles</TableHead>
                                <TableHead class="h-9 text-xs font-semibold">Module Access</TableHead>
                                <TableHead class="h-9 text-xs font-semibold">Permissions</TableHead>
                                <TableHead class="h-9 text-xs font-semibold">Created</TableHead>
                                <TableHead class="h-9 text-xs font-semibold text-right no-print">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="user in users.data" :key="user.id" class="hover:bg-neutral-50 dark:hover:bg-neutral-800/30">
                                <TableCell class="py-2 font-medium">
                                    {{ user.name }}
                                </TableCell>
                                <TableCell class="py-2 text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ user.email }}
                                </TableCell>
                                <TableCell class="py-2">
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-for="role in user.roles"
                                            :key="role"
                                            variant="default"
                                            class="text-xs capitalize"
                                        >
                                            {{ role }}
                                        </Badge>
                                        <span v-if="user.roles.length === 0" class="text-xs text-neutral-400">—</span>
                                    </div>
                                </TableCell>
                                <TableCell class="py-2">
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-for="module in getModuleBadges(user)"
                                            :key="module.name"
                                            :variant="module.variant as any"
                                            class="text-xs"
                                        >
                                            {{ module.name }}
                                        </Badge>
                                        <span v-if="getModuleBadges(user).length === 0" class="text-xs text-neutral-400">—</span>
                                    </div>
                                </TableCell>
                                <TableCell class="py-2">
                                    <Badge variant="outline" class="text-xs">
                                        {{ user.permissions_count }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="py-2 text-xs text-neutral-500">
                                    {{ user.created_at }}
                                </TableCell>
                                <TableCell class="py-2 text-right no-print">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button variant="ghost" size="icon" class="size-8">
                                                <MoreHorizontal class="size-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem as-child>
                                                <Link :href="`/admin/users/${user.id}/edit`">
                                                    <Pencil class="mr-2 size-4" />
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem @click="deleteUser(user)" class="text-red-600">
                                                <Trash class="mr-2 size-4" />
                                                Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="users.last_page > 1" class="no-print flex items-center justify-center gap-2">
                <Link
                    v-for="link in users.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    :class="[
                        'inline-flex items-center justify-center px-3 py-1.5 text-sm rounded-md border transition-colors',
                        link.active
                            ? 'bg-primary text-primary-foreground border-primary'
                            : link.url
                            ? 'bg-background border-input hover:bg-accent hover:text-accent-foreground'
                            : 'opacity-50 cursor-not-allowed bg-background border-input',
                    ]"
                    :disabled="!link.url"
                    preserve-state
                    preserve-scroll
                    v-html="link.label"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style>
@media print {
    .no-print {
        display: none !important;
    }

    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
