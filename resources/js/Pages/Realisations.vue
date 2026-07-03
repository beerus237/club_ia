<template>
  <PageHero
    eyebrow="Nos succès"
    title="Nos réalisations"
    subtitle="Découvrez les projets innovants et les succès du Club IA-ENSPD"
  />

  <!-- Filtres -->
  <section class="sticky top-[65px] z-40 border-b border-brand-100 bg-white/90 py-5 backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-wrap justify-center gap-2.5">
        <button
          type="button"
          class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-300"
          :class="activeCategory === 'all' ? 'bg-brand-gradient text-white shadow-soft' : 'bg-brand-50 text-slate-600 hover:bg-brand-100'"
          @click="activeCategory = 'all'"
        >
          Tous
        </button>
        <button
          v-for="category in categories"
          :key="category"
          type="button"
          class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-300"
          :class="activeCategory === category ? 'bg-brand-gradient text-white shadow-soft' : 'bg-brand-50 text-slate-600 hover:bg-brand-100'"
          @click="activeCategory = category"
        >
          {{ category }}
        </button>
      </div>
    </div>
  </section>

  <!-- Grille unifiée de tous les projets -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Portfolio</span>
        <h2 class="section-title">Nos projets</h2>
        <p class="section-subtitle">Tous les projets menés par les membres du Club IA-ENSPD, tous domaines confondus</p>
      </div>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="(projet, index) in filteredProjets" :key="projet.id" v-reveal="{ delay: (index % 3) * 100 }" class="group surface-card-hover overflow-hidden">
          <div class="relative flex h-48 items-center justify-center overflow-hidden bg-brand-gradient">
            <img v-if="projet.image_url" :src="projet.image_url" :alt="projet.titre" class="h-full w-full object-cover" />
            <CpuIcon v-else class="h-14 w-14 text-white/70" />
            <div class="absolute inset-0 flex items-center justify-center bg-slate-900/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
              <a
                v-if="projet.lien_demo"
                :href="projet.lien_demo"
                target="_blank"
                rel="noopener noreferrer"
                class="rounded-full bg-white/20 px-6 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/30"
              >
                Voir le projet
              </a>
              <span v-else class="rounded-full bg-white/20 px-6 py-2.5 text-sm font-semibold text-white backdrop-blur-sm">Détails</span>
            </div>
          </div>

          <div class="p-6">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ projet.categorie }}</span>
            <h3 class="mb-3 mt-2 text-xl font-bold text-slate-900">{{ projet.titre }}</h3>
            <p class="mb-4 line-clamp-3 text-sm leading-6 text-slate-500">{{ projet.description }}</p>

            <div class="mb-4 flex items-center justify-between">
              <span class="truncate text-sm text-slate-400">{{ projet.equipe }}</span>
              <span class="badge shrink-0" :class="getStatusClass(projet.statut)">{{ projet.statut }}</span>
            </div>

            <div class="flex gap-2.5 border-t border-slate-100 pt-4">
              <a v-if="projet.lien_demo" :href="projet.lien_demo" target="_blank" rel="noopener noreferrer" class="btn-primary btn-sm flex-1">
                <GlobeIcon class="h-4 w-4" />
                Voir le projet
              </a>
              <a v-if="projet.lien_github" :href="projet.lien_github" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-sm flex-1 !border-slate-200 !text-slate-700">
                <CodeIcon class="h-4 w-4" />
                Code source
              </a>
            </div>
          </div>
        </div>
      </div>

      <div v-if="filteredProjets.length === 0" class="py-12 text-center">
        <div class="surface-card mx-auto max-w-md p-10">
          <SearchXIcon class="mx-auto mb-4 h-12 w-12 text-brand-200" />
          <h3 class="mb-2 text-lg font-bold text-slate-900">Aucun projet trouvé</h3>
          <p class="text-sm text-slate-500">Aucun projet ne correspond à cette catégorie pour le moment</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { CodeIcon, CpuIcon, GlobeIcon, SearchXIcon } from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const props = defineProps({
  projets: {
    type: Array,
    default: () => [],
  },
  categories: {
    type: Array,
    default: () => [],
  },
})

const activeCategory = ref('all')

const filteredProjets = computed(() => {
  if (activeCategory.value === 'all') return props.projets
  return props.projets.filter((projet) => projet.categorie === activeCategory.value)
})

const getStatusClass = (statut) => {
  switch (statut) {
    case 'Terminé':
      return 'badge-success'
    case 'En cours':
      return 'badge-brand'
    case 'Planifié':
      return 'badge-warning'
    default:
      return 'badge-neutral'
  }
}
</script>
