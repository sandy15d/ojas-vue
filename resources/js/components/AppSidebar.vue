<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar'
import type { Module } from '@/types'

import * as LucideIcons from 'lucide-vue-next'
import { Settings2 } from 'lucide-vue-next'
import NavMain from '@/components/NavMain.vue'
import NavProjects from '@/components/NavProjects.vue'
import NavUser from '@/components/NavUser.vue'
import AppLogo from '@/components/AppLogo.vue'

import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarRail,
  SidebarMenu,
  SidebarMenuItem,
  SidebarMenuButton,
} from '@/components/ui/sidebar'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import ScrollArea from './ui/scroll-area/ScrollArea.vue'
import { edit } from '@/routes/profile'

const props = withDefaults(defineProps<SidebarProps>(), {
  collapsible: "icon",
})

const page = usePage()
const auth = computed(() => page.props.auth)
const modules = computed<Module[]>(() => (page.props.modules as Module[]) || [])

// Get the icon component from Lucide
const getIcon = (iconName: string) => {
  return (LucideIcons as any)[iconName] || LucideIcons.LayoutDashboard
}

// Get current module based on URL
const getCurrentModuleFromUrl = () => {
  const url = window.location.pathname
  if (url.includes('/sales')) return 'sales'
  if (url.includes('/admin')) return 'admin'
  if (url.includes('/hr')) return 'hr'
  if (url.includes('/cogs')) return 'cogs'
  if (url.includes('/budget')) return 'budget'
  return modules.value[0]?.identifier || null
}

const activeModule = computed(() => {
  const currentIdentifier = getCurrentModuleFromUrl()
  return modules.value.find((m) => m.identifier === currentIdentifier) || modules.value[0]
})

// Convert module menu items to NavMain format
const navMain = computed(() => {
  if (!activeModule.value) return []

  const moduleMenus = activeModule.value.menuItems.map(section => ({
    title: section.title,
    url: section.url,
    icon: getIcon(section.icon || 'LayoutDashboard'),
    items: section.items || []
  }))

  // Add Settings section for all modules
/*   const settingsMenu = {
    title: "Settings",
    url: edit().url,
    icon: Settings2,
    items: [
      {
        title: "Profile",
        url: edit().url,
      },
      {
        title: "Password",
        url: "#",
      },
      {
        title: "Appearance",
        url: "#",
      },
    ],
  } */

  return [...moduleMenus, /* settingsMenu */]
})

// Convert module projects to NavProjects format
const projects = computed(() => {
  if (!activeModule.value) return []

  return activeModule.value.projects.map(project => ({
    name: project.name,
    url: project.url,
    icon: getIcon(project.icon)
  }))
})
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" class="pointer-events-none">
            <AppLogo />
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    <SidebarContent>
      <ScrollArea>
        <NavMain :items="navMain" />
        <NavProjects v-if="projects.length > 0" :projects="projects" />
      </ScrollArea>
    </SidebarContent>
    <SidebarFooter>
      <NavUser :user="auth.user" />
    </SidebarFooter>
    <SidebarRail />
  </Sidebar>
</template>
