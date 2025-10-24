<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Package, TrendingDown, TrendingUp, Warehouse } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'COGS',
        href: '/cogs/dashboard',
    },
    {
        title: 'Dashboard',
        href: '/cogs/dashboard',
    },
];

const stats = [
    { title: 'Total Inventory', value: '12,456', icon: Package, trend: '+7%' },
    { title: 'Cost', value: '$89,234', icon: TrendingUp, trend: '+4%' },
    { title: 'Savings', value: '$5,678', icon: TrendingDown, trend: '-3%' },
    { title: 'Warehouses', value: '8', icon: Warehouse, trend: '0%' },
];
</script>

<template>
    <Head title="COGS Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <!-- Module Indicator -->
            <div class="rounded-xl border border-purple-200 bg-purple-50 p-6 dark:border-purple-900 dark:bg-purple-950">
                <h2 class="text-3xl font-bold text-purple-900 dark:text-purple-100">
                    📦 COGS MODULE DASHBOARD
                </h2>
                <p class="mt-2 text-purple-700 dark:text-purple-300">
                    You are viewing the COGS module - Cost of Goods Sold, inventory, suppliers, and cost analysis
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
                    <span class="text-lg font-medium">Inventory Overview</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
