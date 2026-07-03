<template>
  <PageHero
    eyebrow="Analyse"
    title="Résultats d'analyse"
    subtitle="Découvrez les insights générés à partir des données collectées"
  />

  <!-- Remerciements -->
  <section class="bg-white py-16">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <div v-reveal class="surface-card bg-brand-gradient-soft p-8">
        <h2 class="mb-4 flex items-center justify-center gap-2 text-2xl font-bold text-brand-900">
          <HeartHandshakeIcon class="h-6 w-6 text-brand-600" />
          Merci à nos contributeurs !
        </h2>
        <p class="text-lg leading-8 text-slate-600">
          Grâce à votre générosité, nous pouvons développer des modèles d'IA véritablement représentatifs de la
          diversité africaine. Vos données nous aident à construire l'avenir de l'intelligence artificielle en
          Afrique.
        </p>
        <p class="mt-5 text-3xl font-extrabold text-gradient-brand">
          {{ statistiques.total }} contributions au total !
        </p>
      </div>
    </div>
  </section>

  <!-- Visualisations -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">
          <BarChart3Icon class="h-3.5 w-3.5" />
          Données
        </span>
        <h2 class="section-title">Visualisation des données</h2>
      </div>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Répartition par type -->
        <div v-reveal class="surface-card p-6">
          <h3 class="mb-5 text-lg font-bold text-slate-900">Répartition des contributions</h3>
          <div class="flex items-center justify-center py-4">
            <div class="relative h-40 w-40 shrink-0 rounded-full" :style="{ background: typeDonutGradient }">
              <div class="absolute inset-3 flex items-center justify-center rounded-full bg-white">
                <span class="text-2xl font-extrabold text-brand-600">{{ statistiques.total }}</span>
              </div>
            </div>
          </div>
          <div class="mt-4 space-y-2.5">
            <div v-for="(type, index) in statistiques.par_type" :key="type.type" class="flex items-center justify-between text-sm">
              <span class="flex items-center gap-2 text-slate-500">
                <span class="h-2.5 w-2.5 rounded-full" :style="{ backgroundColor: donutColors[index % donutColors.length] }" />
                {{ type.type }}
              </span>
              <span class="font-semibold text-slate-800">{{ type.total }}</span>
            </div>
          </div>
        </div>

        <!-- Répartition par statut -->
        <div v-reveal="{ delay: 100 }" class="surface-card p-6">
          <h3 class="mb-5 text-lg font-bold text-slate-900">Statut des contributions</h3>
          <div class="space-y-4 py-2">
            <div v-for="statut in statistiques.par_statut" :key="statut.statut">
              <div class="mb-1.5 flex items-center justify-between text-sm">
                <span class="font-medium text-slate-600">{{ statut.statut }}</span>
                <span class="font-semibold text-slate-800">{{ statut.total }}</span>
              </div>
              <div class="h-2.5 w-full overflow-hidden rounded-full bg-brand-100">
                <div
                  class="h-2.5 rounded-full bg-brand-gradient transition-all duration-1000"
                  :style="{ width: `${statistiques.total ? (statut.total / statistiques.total) * 100 : 0}%` }"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Distribution géographique -->
        <div v-reveal="{ delay: 200 }" class="surface-card p-6">
          <h3 class="mb-5 text-lg font-bold text-slate-900">Distribution géographique</h3>
          <div class="flex h-40 items-center justify-center">
            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-brand-100">
              <GlobeIcon class="h-11 w-11 text-brand-600" />
            </div>
          </div>
          <p class="mt-4 text-center text-sm text-slate-500">Répartition géographique des contributeurs</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { BarChart3Icon, GlobeIcon, HeartHandshakeIcon, LineChartIcon } from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const { props } = usePage()
const statistiques = computed(() => props.statistiques || { total: 0, par_type: [], par_statut: [] })

const donutColors = ['#36b3f5', '#0079c4', '#7ccdfb', '#0c446c', '#02609f']

const typeDonutGradient = computed(() => {
  const total = statistiques.value.total || 1
  let acc = 0
  const stops = (statistiques.value.par_type || []).map((type, index) => {
    const pct = (type.total / total) * 100
    const start = acc
    acc += pct
    return `${donutColors[index % donutColors.length]} ${start}% ${acc}%`
  })
  return stops.length ? `conic-gradient(${stops.join(', ')})` : '#e0f1fe'
})
</script>
