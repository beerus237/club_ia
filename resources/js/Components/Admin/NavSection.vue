<template>
  <div class="mt-6 first:mt-0">
    <h3 v-if="title" class="mb-2 px-3.5 text-[11px] font-bold uppercase tracking-[0.15em] text-slate-400">
      {{ title }}
    </h3>
    <div class="space-y-1">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
})
</script>
