<template>
  <header class="sticky top-0 z-30 border-b border-brand-100 bg-white/90 backdrop-blur-xl">
    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6">
      <div class="flex min-w-0 items-center gap-3">
        <button type="button" class="btn-icon shrink-0 lg:hidden" aria-label="Ouvrir le menu" @click="toggle">
          <MenuIcon class="h-5 w-5" />
        </button>
        <div class="min-w-0">
          <h1 class="truncate text-lg font-bold text-slate-900 sm:text-xl">{{ title }}</h1>
          <p v-if="description" class="hidden truncate text-sm text-slate-500 sm:block">{{ description }}</p>
        </div>
      </div>

      <div class="flex shrink-0 items-center gap-2 sm:gap-3">
        <Link href="/admin/contributions" class="btn-icon relative" aria-label="Contributions en attente">
          <BellIcon class="h-5 w-5" />
          <span
            v-if="stats.contributions_pending > 0"
            class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[11px] font-bold text-white ring-2 ring-white"
          >
            {{ stats.contributions_pending }}
          </span>
        </Link>

        <div class="relative">
          <button
            type="button"
            class="flex items-center gap-2.5 rounded-xl border border-transparent py-1.5 pl-1.5 pr-2.5 transition-colors duration-200 hover:border-brand-100 hover:bg-brand-50"
            @click="menuOpen = !menuOpen"
          >
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-gradient text-sm font-bold text-white">A</div>
            <div class="hidden text-left md:block">
              <p class="text-sm font-semibold leading-tight text-slate-900">Administrateur</p>
              <p class="text-xs leading-tight text-slate-500">Club IA-ENSPD</p>
            </div>
            <ChevronDownIcon class="hidden h-4 w-4 text-slate-400 md:block" />
          </button>

          <Transition
            enter-active-class="transition duration-150 ease-out"
            leave-active-class="transition duration-100 ease-in"
            enter-from-class="opacity-0 scale-95"
            leave-to-class="opacity-0 scale-95"
          >
            <div
              v-if="menuOpen"
              v-click-outside="() => (menuOpen = false)"
              class="absolute right-0 top-full mt-2 w-56 overflow-hidden rounded-2xl border border-brand-100 bg-white py-1.5 shadow-card-hover"
            >
              <Link href="/admin/settings" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 transition-colors hover:bg-brand-50 hover:text-brand-700">
                <SettingsIcon class="h-4 w-4" />
                Paramètres
              </Link>
              <Link href="/" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 transition-colors hover:bg-brand-50 hover:text-brand-700">
                <HomeIcon class="h-4 w-4" />
                Voir le site
              </Link>
              <div class="my-1 border-t border-slate-100" />
              <Link
                href="/admin/logout"
                method="post"
                as="button"
                class="flex w-full items-center gap-2.5 px-4 py-2.5 text-left text-sm text-rose-600 transition-colors hover:bg-rose-50"
              >
                <LogOutIcon class="h-4 w-4" />
                Se déconnecter
              </Link>
            </div>
          </Transition>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { BellIcon, ChevronDownIcon, HomeIcon, LogOutIcon, MenuIcon, SettingsIcon } from 'lucide-vue-next'
import { useAdminSidebar } from '@/Composables/useAdminSidebar'

defineProps({
  title: String,
  description: String,
  stats: {
    type: Object,
    default: () => ({ contributions_pending: 0 }),
  },
})

const { toggle } = useAdminSidebar()
const menuOpen = ref(false)

// Tiny local directive: closes the dropdown when clicking anywhere outside it.
const vClickOutside = {
  mounted(el, binding) {
    el.__clickOutsideHandler__ = (event) => {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value(event)
      }
    }
    document.addEventListener('click', el.__clickOutsideHandler__, true)
  },
  unmounted(el) {
    document.removeEventListener('click', el.__clickOutsideHandler__, true)
  },
}
</script>
