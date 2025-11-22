<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { DollarSign, PieChart, TrendingUp, Wallet } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin/dashboard',
    },
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
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
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <!-- Module Indicator -->
            <div class="rounded-xl border border-orange-200 bg-orange-50 p-6 dark:border-orange-900 dark:bg-orange-950">
                <h2 class="text-3xl font-bold text-orange-900 dark:text-orange-100">
                    💰 Admin MODULE DASHBOARD
                </h2>
                <p class="mt-2 text-orange-700 dark:text-orange-300">
                    You are viewing the Admin module - Administrator Setting
                </p>
            </div>
        </div>
    </AppLayout>
</template>
