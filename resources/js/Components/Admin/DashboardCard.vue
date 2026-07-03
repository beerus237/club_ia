<template>
  <div class="surface-card p-5 sm:p-6">
    <div class="mb-5 flex items-center justify-between">
      <h3 class="text-base font-bold text-slate-900">{{ title }}</h3>
      <Link
        v-if="actionLabel && actionTo"
        :href="actionTo"
        class="flex items-center gap-1 text-sm font-semibold text-brand-600 transition-colors hover:text-brand-700"
      >
        {{ actionLabel }}
        <ArrowRightIcon class="h-3.5 w-3.5" />
      </Link>
    </div>
    <slot />
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRightIcon } from 'lucide-vue-next'

defineProps({
  title: String,
  actionLabel: String,
  actionTo: String,
})
</script>
