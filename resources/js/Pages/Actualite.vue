<template>
  <PageHero
    eyebrow="Actualités"
    title="Actualités"
    subtitle="Restez informé des dernières avancées en IA et des événements du club"
  />

  <!-- Actualités dans le monde -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Veille</span>
        <h2 class="section-title">Actualités dans le monde</h2>
        <p class="section-subtitle">Les dernières innovations et avancées en intelligence artificielle à travers le monde</p>
      </div>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="(article, index) in actualitesMonde" :key="article.id" v-reveal="{ delay: (index % 3) * 100 }" class="surface-card-hover overflow-hidden">
          <div class="flex h-48 items-center justify-center bg-brand-gradient">
            <img v-if="article.image_url" :src="article.image_url" :alt="article.titre" class="h-full w-full object-cover" />
            <NewspaperIcon v-else class="h-12 w-12 text-white/70" />
          </div>
          <div class="p-6">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-600">{{ article.categorie }}</span>
            <h3 class="mb-3 mt-2 text-xl font-bold text-slate-900">{{ article.titre }}</h3>
            <p class="mb-4 text-sm leading-6 text-slate-500">{{ article.contenu.substring(0, 100) }}…</p>
            <div class="flex items-center justify-between border-t border-slate-100 pt-4">
              <span class="text-sm text-slate-400">{{ new Date(article.date_publication).toLocaleDateString('fr-FR') }}</span>

              <a
                v-if="article.lien_externe"
                :href="article.lien_externe"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-1 text-sm font-semibold text-brand-600 transition-colors hover:text-brand-700"
              >
                Lire plus
                <ArrowRightIcon class="h-4 w-4" />
              </a>
              <span v-else class="text-sm text-slate-400">Article complet</span>
            </div>
          </div>
        </div>
      </div>

      <div v-if="actualitesMonde.length === 0" class="py-12 text-center">
        <div class="surface-card mx-auto max-w-md p-10">
          <NewspaperIcon class="mx-auto mb-4 h-12 w-12 text-brand-200" />
          <p class="text-sm text-slate-500">Aucune actualité pour le moment</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Événements à venir -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-14 max-w-2xl text-center">
        <span class="section-eyebrow">
          <CalendarIcon class="h-3.5 w-3.5" />
          Agenda
        </span>
        <h2 class="section-title">Événements à venir</h2>
        <p class="section-subtitle">Découvrez les prochains événements organisés par le Club IA-ENSPD</p>
      </div>

      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="(event, index) in evenements" :key="event.id" v-reveal="{ delay: (index % 3) * 100 }" class="surface-card-hover overflow-hidden">
          <div class="relative flex h-40 items-center justify-center bg-brand-gradient">
            <img v-if="event.image_url" :src="event.image_url" :alt="event.titre" class="h-full w-full object-cover" />
            <CalendarIcon v-else class="h-10 w-10 text-white/70" />
          </div>

          <div class="p-5">
            <span class="badge-brand mb-3 inline-flex">Événement</span>

            <h3 class="mb-3 line-clamp-2 text-lg font-bold text-slate-900">{{ event.titre }}</h3>

            <div class="mb-2 flex items-center gap-2 text-slate-500">
              <CalendarIcon class="h-4 w-4 shrink-0 text-brand-500" />
              <span class="text-sm">{{ formatEventDate(event.date_debut, event.date_fin) }}</span>
            </div>

            <div class="mb-3 flex items-center gap-2 text-slate-500">
              <MapPinIcon class="h-4 w-4 shrink-0 text-brand-500" />
              <span class="text-sm">{{ event.lieu }}</span>
            </div>

            <p class="mb-4 line-clamp-3 text-sm leading-6 text-slate-500">{{ event.description }}</p>

            <div class="flex items-center justify-between border-t border-slate-100 pt-4">
              <span class="badge" :class="event.est_actif ? 'badge-success' : 'badge-neutral'">
                {{ event.est_actif ? 'Actif' : 'Complet' }}
              </span>

              <button
                v-if="event.est_actif"
                type="button"
                class="btn-primary btn-sm"
                :disabled="inscribingId === event.id"
                @click="sInscrire(event.id)"
              >
                {{ inscribingId === event.id ? 'Envoi…' : "S'inscrire" }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="evenements.length === 0" class="py-12 text-center">
        <div class="surface-card mx-auto max-w-md p-10">
          <CalendarIcon class="mx-auto mb-4 h-12 w-12 text-brand-200" />
          <h3 class="mb-2 text-lg font-bold text-slate-900">Aucun événement à venir</h3>
          <p class="text-sm text-slate-500">Revenez bientôt pour découvrir nos prochains événements</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3'
import { ArrowRightIcon, CalendarIcon, MapPinIcon, NewspaperIcon } from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const { props } = usePage()
const actualitesMonde = props.actualitesMonde || []
const evenements = props.evenements || []

const inscribingId = ref(null)

const sInscrire = (eventId) => {
  inscribingId.value = eventId
  useForm({}).post(route('evenements.inscrire', eventId), {
    preserveScroll: true,
    onSuccess: () => {
      window.location.reload()
    },
    onFinish: () => {
      inscribingId.value = null
    },
  })
}

const formatEventDate = (dateDebut, dateFin) => {
  const start = new Date(dateDebut)
  const end = dateFin ? new Date(dateFin) : null
  const options = { day: 'numeric', month: 'short' }

  if (!end || start.toDateString() === end.toDateString()) {
    return start.toLocaleDateString('fr-FR', options)
  }
  return `${start.toLocaleDateString('fr-FR', options)} - ${end.toLocaleDateString('fr-FR', options)}`
}
</script>
