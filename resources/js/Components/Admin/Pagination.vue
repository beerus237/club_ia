<template>
  <nav v-if="links.length > 3" class="mt-8 flex flex-wrap items-center justify-center gap-1.5">
    <template v-for="(link, index) in links" :key="index">
      <span
        v-if="link.url === null && !isPrevious(link) && !isNext(link)"
        class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-300"
        v-html="cleanLabel(link.label)"
      />

      <Link
        v-else-if="isPrevious(link)"
        :href="link.url || '#'"
        class="flex items-center gap-1 rounded-lg border border-brand-100 px-3 py-2 text-sm font-medium text-slate-600 transition-colors duration-200 hover:bg-brand-50 hover:text-brand-700"
        :class="{ 'pointer-events-none opacity-40': !link.url }"
      >
        <ChevronLeftIcon class="h-4 w-4" />
        <span class="hidden sm:inline">Précédent</span>
      </Link>

      <Link
        v-else-if="isNext(link)"
        :href="link.url || '#'"
        class="flex items-center gap-1 rounded-lg border border-brand-100 px-3 py-2 text-sm font-medium text-slate-600 transition-colors duration-200 hover:bg-brand-50 hover:text-brand-700"
        :class="{ 'pointer-events-none opacity-40': !link.url }"
      >
        <span class="hidden sm:inline">Suivant</span>
        <ChevronRightIcon class="h-4 w-4" />
      </Link>

      <Link
        v-else-if="link.url"
        :href="link.url"
        class="min-w-[40px] rounded-lg border px-3 py-2 text-center text-sm font-medium transition-colors duration-200"
        :class="link.active ? 'border-brand-600 bg-brand-gradient text-white shadow-soft' : 'border-slate-200 text-slate-600 hover:border-brand-200 hover:bg-brand-50'"
        v-html="cleanLabel(link.label)"
      />
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'

defineProps({
  links: {
    type: Array,
    default: () => [],
  },
})

const isPrevious = (link) => link.label.includes('Previous') || link.label.includes('&laquo;')
const isNext = (link) => link.label.includes('Next') || link.label.includes('&raquo;')
const cleanLabel = (label) => label.replace('&laquo;', '«').replace('&raquo;', '»')
</script>
