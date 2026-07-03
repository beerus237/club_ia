<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="page-hero flex min-h-screen flex-col items-center justify-center px-4 py-10">
    <Link href="/" class="mb-8 flex flex-col items-center gap-3">
      <img src="/images/logos/logo-club.jpeg" alt="Logo Club IA ENSPD" class="h-16 w-16 rounded-2xl object-cover shadow-card ring-1 ring-brand-100" />
      <span class="text-sm font-bold uppercase tracking-[0.25em] text-brand-700">Club IA-ENSPD</span>
    </Link>

    <div class="w-full overflow-hidden rounded-2xl border border-brand-100 bg-white px-6 py-7 shadow-card-hover sm:max-w-md sm:px-8 sm:py-8">
      <slot />
    </div>

    <Link href="/" class="mt-6 text-sm font-medium text-slate-500 transition-colors hover:text-brand-600">
      &larr; Retour au site
    </Link>
  </div>
</template>
