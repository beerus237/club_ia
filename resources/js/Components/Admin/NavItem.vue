<template>
  <Link
    :href="href"
    class="group flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-200"
    :class="[
      active ? 'bg-brand-gradient text-white shadow-soft' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700',
      level > 0 ? 'pl-9' : '',
    ]"
  >
    <component
      :is="icon"
      class="h-[18px] w-[18px] shrink-0"
      :class="active ? 'text-white' : 'text-slate-400 group-hover:text-brand-600'"
    />
    <span class="flex-1 truncate">{{ label }}</span>
    <span
      v-if="badge"
      class="ml-auto inline-flex h-5 min-w-[20px] items-center justify-center rounded-full px-1.5 text-[11px] font-bold"
      :class="active ? 'bg-white/25 text-white' : badgeColor === 'red' ? 'bg-rose-100 text-rose-600' : 'bg-brand-100 text-brand-700'"
    >
      {{ badge }}
    </span>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: String,
  icon: Object,
  label: String,
  active: Boolean,
  badge: [Number, String],
  badgeColor: {
    type: String,
    default: 'blue',
  },
  level: {
    type: Number,
    default: 0,
  },
})
</script>
