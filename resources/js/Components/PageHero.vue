<template>
  <section class="page-hero py-24 sm:py-28">
    <div class="page-hero-orb-1" />
    <div class="page-hero-orb-2" />

    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <div v-if="eyebrow" v-reveal class="badge-float mx-auto">
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(74,222,128,0.9)]" />
        {{ eyebrow }}
      </div>

      <h1 v-reveal="{ delay: 80 }" class="mt-6 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
        {{ title }}
      </h1>

      <p v-if="subtitle" v-reveal="{ delay: 140 }" class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl">
        {{ subtitle }}
      </p>

      <div v-if="$slots.default" v-reveal="{ delay: 200 }" class="mt-8">
        <slot />
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  eyebrow: String,
  title: String,
  subtitle: String,
})
</script>
