<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ChevronsUpDown, Check } from 'lucide-vue-next';
import * as LucideIcons from 'lucide-vue-next';
import type { Module } from '@/types';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';

const page = usePage();
const modules = computed<Module[]>(() => (page.props.modules as Module[]) || []);

const getCurrentModuleFromUrl = () => {
    const url = window.location.pathname;
    if (url.includes('/admin')) return 'admin';
    if (url.includes('/sales')) return 'sales';
    if (url.includes('/hr')) return 'hr';
    if (url.includes('/cogs')) return 'cogs';
    if (url.includes('/budget')) return 'budget';
    return modules.value[0]?.identifier || 'sales';
};

const currentModule = ref(getCurrentModuleFromUrl());

const activeModule = computed(() => {
    return modules.value.find((m) => m.identifier === currentModule.value) || modules.value[0];
});

const { isMobile } = useSidebar();

const switchModule = (moduleIdentifier: string) => {
    console.log('Switching to module:', moduleIdentifier);
    console.log('Available modules:', modules.value);

    currentModule.value = moduleIdentifier;
    localStorage.setItem('current_module', moduleIdentifier);

    const module = modules.value.find((m) => m.identifier === moduleIdentifier);
    console.log('Found module:', module);

    if (module && module.dashboardRoute) {
        console.log('Navigating to:', module.dashboardRoute);
        router.visit(module.dashboardRoute);
    } else {
        console.error('Module or dashboardRoute not found!');
    }
};

const getIcon = (iconName: string) => {
    return (LucideIcons as any)[iconName] || LucideIcons.LayoutDashboard;
};
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="md"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                    >
                        <div
                            class="flex aspect-square size-6 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground"
                        >
                            <component
                                :is="getIcon(activeModule?.icon)"
                                class="size-3"
                            />
                        </div>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">
                                {{ activeModule?.name }}
                            </span>
                            <span class="truncate text-xs">Module</span>
                        </div>
                        <ChevronsUpDown class="ml-auto" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-[--reka-sidebar-menu-button-size] min-w-56 rounded-lg"
                    align="start"
                    :side="isMobile ? 'bottom' : 'right'"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="text-xs text-neutral-500">
                        Switch Module
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem
                        v-for="module in modules"
                        :key="module.identifier"
                        @click="switchModule(module.identifier)"
                        class="gap-2 p-2"
                    >
                        <div
                            class="flex size-6 items-center justify-center rounded-sm border"
                        >
                            <component
                                :is="getIcon(module.icon)"
                                class="size-4 shrink-0"
                            />
                        </div>
                        {{ module.name }}
                        <Check
                            v-if="module.identifier === currentModule"
                            class="ml-auto size-4"
                        />
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
