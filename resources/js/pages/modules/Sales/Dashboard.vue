<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { BarChart3, ShoppingCart, TrendingUp, Users } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sales',
        href: '/sales/dashboard',
    },
    {
        title: 'Dashboard',
        href: '/sales/dashboard',
    },
];

const stats = [
    { title: 'Total Orders', value: '1,234', icon: ShoppingCart, trend: '+12%' },
    { title: 'Revenue', value: '$45,678', icon: TrendingUp, trend: '+8%' },
    { title: 'Customers', value: '567', icon: Users, trend: '+15%' },
    { title: 'Conversion', value: '3.2%', icon: BarChart3, trend: '+2%' },
];
</script>

<template>
    <Head title="Sales Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <!-- Module Indicator -->
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-6 dark:border-blue-900 dark:bg-blue-950">
                <h2 class="text-3xl font-bold text-blue-900 dark:text-blue-100">
                    📊 SALES MODULE DASHBOARD
                </h2>
                <p class="mt-2 text-blue-700 dark:text-blue-300">
                    You are viewing the Sales module - Track orders, revenue, customers, and sales performance
                </p>
            </div>

            <!-- Stats Grid -->
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

            <!-- Main Content -->
            <div class="grid gap-4 md:grid-cols-2">
                <div
                    class="relative min-h-[400px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <span class="text-lg font-medium">Recent Orders</span>
                    </div>
                </div>
                <div
                    class="relative min-h-[400px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <span class="text-lg font-medium">Sales Chart</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
