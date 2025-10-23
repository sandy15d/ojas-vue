<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar'

import {
  AudioWaveform,
  BookOpen,
  Bot,
  Command,
  Frame,
  GalleryVerticalEnd,
  Home,
  LayoutDashboard,
  Map,
  PieChart,
  Scroll,
  Settings2,
  SquareTerminal,
  Users, 
  LayoutGrid
} from "lucide-vue-next"
import NavMain from '@/components/NavMain.vue'
import NavProjects from '@/components/NavProjects.vue'
import NavUser from '@/components/NavUser.vue'
import TeamSwitcher from '@/components/TeamSwitcher.vue'

import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarRail,
} from '@/components/ui/sidebar'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import ScrollArea from './ui/scroll-area/ScrollArea.vue'
import { dashboard } from '@/routes'
import { edit } from '@/routes/profile'
import Dashboard from '@/pages/Dashboard.vue'

const props = withDefaults(defineProps<SidebarProps>(), {
  collapsible: "icon",
})

const page = usePage()
const auth = computed(() => page.props.auth)

const data = {
  teams: [
    {
      name: "Acme Inc",
      logo: GalleryVerticalEnd,
      plan: "Enterprise",
    },
    {
      name: "Acme Corp.",
      logo: AudioWaveform,
      plan: "Startup",
    },
    {
      name: "Evil Corp.",
      logo: Command,
      plan: "Free",
    },
  ],
  navMain: [
  {
      title: "Dashboard",
      url: "#",
      icon: LayoutGrid,
      items: [
        {
          title: "Default",
          url: dashboard().url
        },
       
      ],
    },
    {
      title: "Users",
      url: "#",
      icon: Users,
      items: [
        {
          title: "All Users",
          url: "#",
        },
        {
          title: "Add New",
          url: "#",
        },
        {
          title: "Roles",
          url: "#",
        },
      ],
    },
    {
      title: "Analytics",
      url: "#",
      icon: PieChart,
      items: [
        {
          title: "Overview",
          url: "#",
        },
        {
          title: "Reports",
          url: "#",
        },
        {
          title: "Statistics",
          url: "#",
        },
      ],
    },
    {
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
    },
  ],
  projects: [
    {
      name: "Design Engineering",
      url: "#",
      icon: Frame,
    },
    {
      name: "Sales & Marketing",
      url: "#",
      icon: PieChart,
    },
    {
      name: "Travel",
      url: "#",
      icon: Map,
    },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader>
      <TeamSwitcher :teams="data.teams" />
    </SidebarHeader>
    <SidebarContent>
      <ScrollArea>
        <NavMain :items="data.navMain" />
        <NavProjects :projects="data.projects" />
      </ScrollArea>
    </SidebarContent>
    <SidebarFooter>
      <NavUser :user="auth.user" />
    </SidebarFooter>
    <SidebarRail />
  </Sidebar>
</template>
