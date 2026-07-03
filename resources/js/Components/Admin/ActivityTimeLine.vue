<template>
  <div class="space-y-4">
    <div v-for="(activity, index) in activities" :key="index" class="flex items-start gap-3">
      <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl" :class="activityTypeColors[activity.type]">
        <component :is="activityTypeIcons[activity.type]" class="h-4.5 w-4.5" />
      </div>
      <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-semibold text-slate-900">{{ activity.title }}</p>
        <p class="text-xs text-slate-400">{{ activity.action }} • {{ activity.time }}</p>
        <p class="mt-0.5 text-xs text-slate-400">par {{ activity.user }}</p>
      </div>
    </div>

    <div v-if="activities.length === 0" class="py-10 text-center">
      <ActivityIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
      <p class="text-sm text-slate-400">Aucune activité récente</p>
    </div>
  </div>
</template>

<script setup>
import { ActivityIcon, CalendarIcon, FolderIcon, NewspaperIcon, ShieldIcon } from 'lucide-vue-next'

defineProps({
  activities: {
    type: Array,
    default: () => [],
  },
})

const activityTypeIcons = {
  actualite: NewspaperIcon,
  evenement: CalendarIcon,
  projet: FolderIcon,
  contribution: ShieldIcon,
  system: ActivityIcon,
}

const activityTypeColors = {
  actualite: 'bg-brand-100 text-brand-600',
  evenement: 'bg-emerald-100 text-emerald-600',
  projet: 'bg-violet-100 text-violet-600',
  contribution: 'bg-amber-100 text-amber-600',
  system: 'bg-slate-100 text-slate-500',
}
</script>
