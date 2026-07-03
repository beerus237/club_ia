<template>
  <Head :title="content.title" />

  <section class="page-hero flex items-center justify-center py-32">
    <div class="page-hero-orb-1" />
    <div class="page-hero-orb-2" />

    <div class="relative mx-auto max-w-lg px-4 text-center sm:px-6">
      <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-3xl bg-brand-gradient shadow-card">
        <component :is="content.icon" class="h-9 w-9 text-white" />
      </div>

      <p class="text-sm font-bold uppercase tracking-[0.3em] text-brand-600">Erreur {{ status }}</p>
      <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ content.title }}</h1>
      <p class="mx-auto mt-4 max-w-md text-base leading-7 text-slate-500">{{ content.message }}</p>

      <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
        <button type="button" class="btn-secondary" @click="$inertia.reload()">
          <RefreshCwIcon class="h-4 w-4" />
          Réessayer
        </button>
        <Link href="/" class="btn-primary">
          <HomeIcon class="h-4 w-4" />
          Retour à l'accueil
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { AlertTriangleIcon, ClockIcon, HomeIcon, LockIcon, RefreshCwIcon, SearchXIcon, ServerCrashIcon } from 'lucide-vue-next'

const props = defineProps({
  status: {
    type: Number,
    required: true,
  },
})

const messages = {
  403: {
    icon: LockIcon,
    title: 'Accès refusé',
    message: "Vous n'avez pas la permission d'accéder à cette page.",
  },
  404: {
    icon: SearchXIcon,
    title: 'Page introuvable',
    message: "La page que vous cherchez n'existe pas ou a été déplacée.",
  },
  419: {
    icon: ClockIcon,
    title: 'Session expirée',
    message: 'Votre session a expiré par inactivité. Veuillez réessayer.',
  },
  429: {
    icon: AlertTriangleIcon,
    title: 'Trop de tentatives',
    message: 'Vous avez effectué trop de requêtes. Merci de patienter un instant avant de réessayer.',
  },
  500: {
    icon: ServerCrashIcon,
    title: 'Erreur serveur',
    message: "Une erreur inattendue s'est produite de notre côté. Notre équipe a été informée.",
  },
  503: {
    icon: ServerCrashIcon,
    title: 'Maintenance en cours',
    message: 'Le site est en maintenance. Merci de revenir dans quelques instants.',
  },
}

const content = computed(() => messages[props.status] || messages[500])
</script>
