import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface Module {
    name: string;
    identifier: string;
    icon: string;
    dashboardRoute: string;
    menuItems: MenuSection[];
    projects: ProjectItem[];
}

export interface MenuSection {
    title: string;
    url: string;
    icon?: string;
    items?: MenuItem[];
}

export interface MenuItem {
    title: string;
    url: string;
    permission?: string;
}

export interface ProjectItem {
    name: string;
    url: string;
    icon: string;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    modules?: Module[];
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
