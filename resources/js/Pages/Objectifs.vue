<template>
  <PageHero
    eyebrow="Feuille de route"
    title="Nos objectifs"
    subtitle="La feuille de route stratégique du Club IA-ENSPD pour les 5 prochaines années."
  />

  <!-- Objectifs permanents -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Socle</span>
        <h2 class="section-title">Objectifs permanents</h2>
        <p class="section-subtitle">Les fondations immuables de notre action quotidienne</p>
      </div>

      <div class="grid gap-8 md:grid-cols-2">
        <div v-reveal class="surface-card-hover group p-8">
          <div class="icon-tile mb-6">
            <DatabaseIcon class="h-6 w-6 text-white" />
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Collecte de données</h3>
          <p class="mb-5 leading-7 text-slate-500">
            Assurer la collecte continue et sécurisée de données diversifiées pour enrichir nos modèles d'IA.
          </p>
          <div class="surface-muted p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-600">Objectif</p>
            <p class="mt-1 text-lg font-bold text-slate-900">+5 To de données africaines par trimestre</p>
          </div>
        </div>

        <div v-reveal="{ delay: 100 }" class="surface-card-hover group p-8">
          <div class="icon-tile mb-6">
            <SearchIcon class="h-6 w-6 text-white" />
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Veille technologique</h3>
          <p class="mb-5 leading-7 text-slate-500">
            Maintenir une veille active sur les nouvelles avancées en IA et intégrer les technologies pertinentes.
          </p>
          <div class="surface-muted p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-600">Objectif</p>
            <p class="mt-1 text-lg font-bold text-slate-900">12 rapports de veille par an</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Feuille de route par horizon -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Vision</span>
        <h2 class="section-title">Feuille de route stratégique</h2>
      </div>

      <div class="grid gap-8 md:grid-cols-3">
        <div v-for="(horizon, index) in horizons" :key="horizon.title" v-reveal="{ delay: index * 100 }" class="surface-card-hover group p-7 text-center">
          <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-100 transition-transform duration-500 group-hover:scale-110">
            <component :is="horizon.icon" class="h-7 w-7 text-brand-600" />
          </div>
          <h3 class="mb-1 text-lg font-bold text-slate-900">{{ horizon.title }}</h3>
          <p class="mb-5 text-sm font-medium text-brand-600">{{ horizon.subtitle }}</p>
          <ul class="space-y-3 text-left">
            <li v-for="item in horizon.items" :key="item" class="flex items-start gap-2.5">
              <CheckCircle2Icon class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" />
              <span class="text-sm leading-6 text-slate-600">{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Indicateurs de performance -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Suivi</span>
        <h2 class="section-title">Indicateurs de performance</h2>
      </div>

      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="(kpi, index) in kpis" :key="kpi.id" v-reveal="{ delay: index * 80 }" class="surface-card p-6 text-center">
          <div class="text-3xl font-extrabold text-gradient-brand">{{ kpi.valeur }}</div>
          <div class="mt-1 text-sm text-slate-500">{{ kpi.label }}</div>
          <div class="mt-4 h-2 w-full overflow-hidden rounded-full bg-brand-100">
            <div class="h-2 rounded-full bg-brand-gradient transition-all duration-1000" :style="`width: ${kpi.progress}%`" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { RocketIcon, StarIcon, GlobeIcon, DatabaseIcon, SearchIcon, CheckCircle2Icon, TargetIcon } from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const horizons = [
  {
    title: 'Court terme',
    subtitle: '6 – 12 mois',
    icon: RocketIcon,
    items: [
      'Rayonnement local : 10+ événements de sensibilisation',
      'Communication : 5 000+ visiteurs mensuels',
      'Optimisation du référencement',
    ],
  },
  {
    title: 'Moyen terme',
    subtitle: '1 – 3 ans',
    icon: StarIcon,
    items: [
      'Innovation : 5+ projets IA concrets',
      'Partenariats stratégiques : 3+ collaborations',
      'Solutions pour problématiques locales',
    ],
  },
  {
    title: 'Long terme',
    subtitle: '3 – 5 ans',
    icon: GlobeIcon,
    items: [
      'Pôle d\'excellence panafricain',
      'Centre de référence en IA',
      'Attraction de talents et d\'investissements',
    ],
  },
]

const kpis = [
  { id: 1, valeur: '75%', label: 'Collecte de données', progress: 75 },
  { id: 2, valeur: '60%', label: 'Visibilité', progress: 60 },
  { id: 3, valeur: '40%', label: 'Partenariats', progress: 40 },
  { id: 4, valeur: '25%', label: 'Projets IA', progress: 25 },
]
</script>
