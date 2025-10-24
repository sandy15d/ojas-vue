<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { DollarSign, PieChart, TrendingUp, Wallet } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Budget',
        href: '/budget/dashboard',
    },
    {
        title: 'Dashboard',
        href: '/budget/dashboard',
    },
];

const stats = [
    { title: 'Total Budget', value: '$250,000', icon: DollarSign, trend: '+10%' },
    { title: 'Spent', value: '$175,000', icon: Wallet, trend: '70%' },
    { title: 'Remaining', value: '$75,000', icon: TrendingUp, trend: '30%' },
    { title: 'Categories', value: '12', icon: PieChart, trend: '0%' },
];
</script>

<template>
    <Head title="Budget Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <!-- Module Indicator -->
            <div class="rounded-xl border border-orange-200 bg-orange-50 p-6 dark:border-orange-900 dark:bg-orange-950">
                <h2 class="text-3xl font-bold text-orange-900 dark:text-orange-100">
                    💰 BUDGET MODULE DASHBOARD
                </h2>
                <p class="mt-2 text-orange-700 dark:text-orange-300">
                    You are viewing the Budget module - Budget planning, expenses, forecasts, and financial management
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
                    <span class="text-lg font-medium">Budget Analysis</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
