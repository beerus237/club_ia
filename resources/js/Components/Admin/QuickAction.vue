<template>
  <Link :href="to" class="surface-card-hover group flex items-center p-4">
    <div class="mr-4 flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition-colors duration-300" :class="iconBgColor">
      <component :is="icon" class="h-5 w-5" :class="iconColor" />
    </div>
    <div class="min-w-0 flex-1">
      <p class="truncate font-semibold text-slate-900">{{ title }}</p>
      <p class="text-sm text-slate-400">Accéder à la fonction</p>
    </div>
    <ArrowRightIcon class="h-4 w-4 shrink-0 text-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:text-brand-600" />
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRightIcon } from 'lucide-vue-next'
import { computed } from 'vue'

const props = defineProps({
  title: String,
  icon: Object,
  color: {
    type: String,
    default: 'brand',
  },
  to: {
    type: String,
    default: '#',
  },
})

const colorClasses = {
  brand: { icon: 'text-brand-600', bg: 'bg-brand-100 group-hover:bg-brand-200' },
  emerald: { icon: 'text-emerald-600', bg: 'bg-emerald-100 group-hover:bg-emerald-200' },
  amber: { icon: 'text-amber-600', bg: 'bg-amber-100 group-hover:bg-amber-200' },
  rose: { icon: 'text-rose-600', bg: 'bg-rose-100 group-hover:bg-rose-200' },
}

const iconColor = computed(() => (colorClasses[props.color] || colorClasses.brand).icon)
const iconBgColor = computed(() => (colorClasses[props.color] || colorClasses.brand).bg)
</script>
