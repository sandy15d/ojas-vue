<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Clock, Users, UserCheck, UserX } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'HR',
        href: '/hr/dashboard',
    },
    {
        title: 'Dashboard',
        href: '/hr/dashboard',
    },
];

const stats = [
    { title: 'Total Employees', value: '234', icon: Users, trend: '+5%' },
    { title: 'Present Today', value: '218', icon: UserCheck, trend: '93%' },
    { title: 'On Leave', value: '12', icon: UserX, trend: '-2%' },
    { title: 'Avg Hours', value: '8.2', icon: Clock, trend: '+0.3' },
];
</script>

<template>
    <Head title="HR Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <!-- Module Indicator -->
            <div class="rounded-xl border border-green-200 bg-green-50 p-6 dark:border-green-900 dark:bg-green-950">
                <h2 class="text-3xl font-bold text-green-900 dark:text-green-100">
                    👥 HR MODULE DASHBOARD
                </h2>
                <p class="mt-2 text-green-700 dark:text-green-300">
                    You are viewing the HR module - Manage employees, attendance, payroll, and human resources
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.title"
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 bg-white p-6 dark:border-sidebar-border dark:bg-neutral-900"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                {{ stat.title }}
                            </p>
                            <h3 class="mt-2 text-2xl font-semibold">
                                {{ stat.value }}
                            </h3>
                            <p class="mt-1 text-xs text-green-600">{{ stat.trend }}</p>
                        </div>
                        <component
                            :is="stat.icon"
                            class="size-8 text-neutral-400"
                        />
                    </div>
                </div>
            </div>

            <div
                class="relative min-h-[500px] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-lg font-medium">HR Analytics</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
