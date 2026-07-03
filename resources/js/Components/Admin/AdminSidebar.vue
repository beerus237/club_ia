<template>
  <!-- Mobile backdrop -->
  <Transition
    enter-active-class="transition-opacity duration-300"
    leave-active-class="transition-opacity duration-200"
    enter-from-class="opacity-0"
    leave-to-class="opacity-0"
  >
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
      @click="close"
    />
  </Transition>

  <aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-brand-100 bg-white transition-transform duration-300 ease-smooth lg:static lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0 shadow-card-hover' : ''"
  >
    <!-- Logo -->
    <div class="flex h-20 shrink-0 items-center gap-3 border-b border-brand-100 px-6">
      <img src="/images/logos/logo-club.jpeg" alt="Logo Club IA ENSPD" class="h-11 w-11 rounded-xl object-cover ring-1 ring-brand-100" />
      <div class="leading-tight">
        <p class="text-sm font-extrabold text-slate-900">Espace Admin</p>
        <p class="text-xs font-medium text-brand-600">Club IA-ENSPD</p>
      </div>
      <button type="button" class="btn-icon ml-auto lg:hidden" aria-label="Fermer le menu" @click="close">
        <XIcon class="h-5 w-5" />
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
      <NavItem
        href="/admin/dashboard"
        :icon="LayoutDashboardIcon"
        label="Tableau de bord"
        :active="$page.url === '/admin/dashboard'"
      />

      <NavSection title="Gestion de contenu">
        <NavItem
          href="/admin/actualites"
          :icon="NewspaperIcon"
          label="Actualités"
          :active="$page.url.startsWith('/admin/actualites')"
        />
        <NavItem
          href="/admin/evenements"
          :icon="CalendarIcon"
          label="Événements"
          :active="$page.url.startsWith('/admin/evenements')"
        />
        <NavItem
          href="/admin/projets"
          :icon="FolderOpenIcon"
          label="Projets"
          :active="$page.url.startsWith('/admin/projets')"
        />
      </NavSection>

      <NavSection title="Contenu principal">
        <NavItem
          href="/admin/carousel"
          :icon="ImageIcon"
          label="Carousel accueil"
          :active="$page.url.startsWith('/admin/carousel')"
        />
        <NavItem
          href="/admin/meilleure-realisation/edit"
          :icon="TrophyIcon"
          label="Meilleure réalisation"
          :active="$page.url.startsWith('/admin/meilleure-realisation')"
        />
      </NavSection>

      <NavSection title="Modération">
        <NavItem
          href="/admin/contributions"
          :icon="ShieldIcon"
          label="Contributions"
          :active="$page.url.startsWith('/admin/contributions')"
          :badge="stats.contributions_pending || null"
          badge-color="red"
        />
      </NavSection>

      <NavSection title="Compte">
        <NavItem
          href="/admin/settings"
          :icon="SettingsIcon"
          label="Paramètres"
          :active="$page.url.startsWith('/admin/settings')"
        />
      </NavSection>
    </nav>

    <!-- Footer -->
    <div class="shrink-0 border-t border-brand-100 p-4">
      <Link
        href="/"
        class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-medium text-slate-500 transition-colors duration-200 hover:bg-brand-50 hover:text-brand-700"
      >
        <ArrowLeftIcon class="h-4 w-4" />
        Retour au site
      </Link>
    </div>
  </aside>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import {
  ArrowLeftIcon,
  CalendarIcon,
  CpuIcon,
  FolderOpenIcon,
  ImageIcon,
  LayoutDashboardIcon,
  NewspaperIcon,
  SettingsIcon,
  ShieldIcon,
  TrophyIcon,
  XIcon,
} from 'lucide-vue-next'
import NavItem from '@/Components/Admin/NavItem.vue'
import NavSection from '@/Components/Admin/NavSection.vue'
import { useAdminSidebar } from '@/Composables/useAdminSidebar'

defineProps({
  stats: {
    type: Object,
    default: () => ({
      contributions_pending: 0,
    }),
  },
})

const { sidebarOpen, close } = useAdminSidebar()
</script>
