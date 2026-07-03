<template>
  <div class="space-y-2.5">
    <div
      v-for="contribution in contributions"
      :key="contribution.id"
      class="group flex items-center justify-between gap-3 rounded-xl border border-transparent bg-brand-50/40 p-3.5 transition-all duration-200 hover:border-brand-100 hover:bg-brand-50"
    >
      <div class="flex min-w-0 flex-1 items-center gap-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg" :class="typeColors[contribution.type]">
          <component :is="typeIcons[contribution.type]" class="h-4 w-4" />
        </div>
        <div class="min-w-0 flex-1">
          <p class="truncate text-sm font-semibold text-slate-900">{{ contribution.titre }}</p>
          <p class="flex items-center gap-1.5 truncate text-xs text-slate-400">
            <span>{{ contribution.user }}</span>
            <span>•</span>
            <span>{{ contribution.created_at }}</span>
          </p>
        </div>
      </div>
      <Link
        :href="`/admin/contributions/${contribution.id}`"
        class="btn-secondary btn-sm shrink-0"
      >
        <EyeIcon class="h-4 w-4" />
        <span class="hidden sm:inline">Voir</span>
      </Link>
    </div>

    <div v-if="contributions.length === 0" class="py-10 text-center">
      <InboxIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
      <p class="text-sm text-slate-500">Aucune contribution en attente</p>
      <p class="mt-1 text-xs text-slate-400">Toutes les contributions sont traitées</p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { DatabaseIcon, EyeIcon, FileTextIcon, ImageIcon, InboxIcon } from 'lucide-vue-next'

defineProps({
  contributions: {
    type: Array,
    default: () => [],
  },
})

const typeIcons = {
  image: ImageIcon,
  texte: FileTextIcon,
  dataset: DatabaseIcon,
}

const typeColors = {
  image: 'bg-brand-100 text-brand-600',
  texte: 'bg-emerald-100 text-emerald-600',
  dataset: 'bg-violet-100 text-violet-600',
}
</script>
