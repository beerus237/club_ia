<template>
  <Link
    :href="to"
    class="surface-card-hover group block p-5"
  >
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-slate-500">{{ title }}</p>
        <p class="mt-1.5 text-3xl font-extrabold text-slate-900">{{ formattedValue }}</p>
      </div>
      <div class="flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-300" :class="iconBgColor">
        <component :is="icon" class="h-6 w-6" :class="iconColor" />
      </div>
    </div>
    <div class="mt-4 flex items-center gap-1 border-t border-slate-100 pt-3 text-xs font-medium text-brand-600">
      <span>Voir les détails</span>
      <ArrowRightIcon class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRightIcon } from 'lucide-vue-next'
import { computed } from 'vue'

const props = defineProps({
  title: String,
  value: [Number, String],
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

const formattedValue = computed(() => {
  if (typeof props.value === 'number' && props.value > 1000) {
    return Math.floor(props.value / 1000) + 'k'
  }
  return props.value
})
</script>
