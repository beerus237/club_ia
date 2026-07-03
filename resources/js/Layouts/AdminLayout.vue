<template>
  <div class="flex min-h-screen bg-brand-50/30">
    <AdminSidebar :stats="stats" />

    <div class="flex min-w-0 flex-1 flex-col">
      <AdminHeader :title="title" :description="description" :stats="stats" />

      <main class="flex-1 p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl animate-fade-in-up">
          <slot />
        </div>
      </main>
    </div>

    <FlashToast />
  </div>
</template>

<script setup>
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue'
import AdminHeader from '@/Components/Admin/AdminHeader.vue'
import FlashToast from '@/Components/FlashToast.vue'

defineProps({
  title: String,
  description: String,
  stats: {
    type: Object,
    default: () => ({
      contributions_pending: 0,
      actualites_count: 0,
      evenements_count: 0,
      projets_count: 0,
    }),
  },
})
</script>
