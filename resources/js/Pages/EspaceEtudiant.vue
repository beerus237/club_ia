<template>
  <PageHero
    eyebrow="Étudiants"
    title="Espace étudiant"
    subtitle="Découvrez les parcours académiques et les opportunités qui s'offrent à vous"
  />

  <!-- Cursus -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Parcours</span>
        <h2 class="section-title">Cursus Science Ingénieur vs Cursus Ingénieur</h2>
        <p class="section-subtitle">Deux parcours d'excellence pour former les leaders de demain en intelligence artificielle</p>
      </div>

      <div class="mb-14 grid gap-8 md:grid-cols-2">
        <div v-reveal class="surface-card-hover p-8">
          <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-gradient">
              <FlaskConicalIcon class="h-7 w-7 text-white" />
            </div>
            <h3 class="mb-1 text-2xl font-bold text-slate-900">Cursus Science Ingénieur</h3>
            <p class="font-semibold text-brand-600">Orientation Recherche</p>
          </div>
          <ul class="space-y-3">
            <li v-for="item in cursusScience" :key="item" class="flex items-center gap-3">
              <div class="h-2 w-2 shrink-0 rounded-full bg-brand-500" />
              <span class="text-slate-600">{{ item }}</span>
            </li>
          </ul>
        </div>

        <div v-reveal="{ delay: 100 }" class="surface-card-hover p-8">
          <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-800">
              <SettingsIcon class="h-7 w-7 text-white" />
            </div>
            <h3 class="mb-1 text-2xl font-bold text-slate-900">Cursus Ingénieur</h3>
            <p class="font-semibold text-slate-500">Orientation Conception</p>
          </div>
          <ul class="space-y-3">
            <li v-for="item in cursusIngenieur" :key="item" class="flex items-center gap-3">
              <div class="h-2 w-2 shrink-0 rounded-full bg-slate-700" />
              <span class="text-slate-600">{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>

      <div v-reveal class="text-center">
        <a href="/syllabus.pdf" download class="btn-primary inline-flex px-8 py-4">
          <DownloadIcon class="h-5 w-5" />
          Télécharger le syllabus de cours (PDF)
        </a>
      </div>
    </div>
  </section>

  <!-- SDIA -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Formation</span>
        <h2 class="section-title">SDIA — Science de Données et Intelligence Artificielle</h2>
        <p class="section-subtitle">Une formation généraliste offrant des compétences solides en Data Science et Intelligence Artificielle</p>
      </div>

      <div class="grid items-center gap-12 md:grid-cols-2">
        <div v-reveal>
          <h3 class="mb-6 text-xl font-bold text-slate-900">Compétences acquises</h3>
          <div class="space-y-3">
            <div v-for="skill in sdiaSkills" :key="skill" class="surface-card flex items-center gap-4 p-4">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100">
                <CheckIcon class="h-4.5 w-4.5 text-brand-600" />
              </div>
              <span class="font-medium text-slate-700">{{ skill }}</span>
            </div>
          </div>
        </div>

        <div v-reveal="{ delay: 100 }" class="surface-card p-8">
          <h3 class="mb-4 text-xl font-bold text-slate-900">Valeur ajoutée</h3>
          <p class="mb-6 leading-7 text-slate-500">
            Notre cursus SDIA offre une approche équilibrée entre théorie et pratique, préparant les étudiants aux
            défis du marché de l'emploi en intelligence artificielle.
          </p>
          <div class="surface-muted p-6">
            <QuoteIcon class="mb-3 h-7 w-7 text-brand-500" />
            <p class="mb-4 italic leading-7 text-slate-600">
              « Le programme SDIA m'a offert les compétences nécessaires pour exceller dans le domaine de la data
              science. Une formation complète et moderne. »
            </p>
            <p class="font-semibold text-brand-700">— Ancien étudiant, Data Scientist</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Débouchés métiers -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Carrières</span>
        <h2 class="section-title">Débouchés métiers</h2>
        <p class="section-subtitle">Découvrez les opportunités professionnelles après votre formation</p>
      </div>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="(job, index) in metiers" :key="job.title" v-reveal="{ delay: (index % 3) * 100 }" class="surface-card-hover group p-6">
          <div class="icon-tile mb-4 !h-12 !w-12 !rounded-xl">
            <component :is="job.icon" class="h-6 w-6" />
          </div>
          <h3 class="mb-2 text-xl font-bold text-slate-900">{{ job.title }}</h3>
          <p class="mb-3 text-sm leading-6 text-slate-500">{{ job.role }}</p>
          <p class="text-sm font-semibold text-brand-600">{{ job.sector }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Statistiques -->
  <section class="bg-gradient-to-br from-brand-950 to-slate-950 py-20 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <h2 class="text-3xl font-extrabold sm:text-4xl">Que deviennent nos étudiants après leur cursus ?</h2>
        <p class="mx-auto mt-4 max-w-3xl text-lg text-brand-100/80">Tendances migratoires et opportunités de carrière</p>
      </div>

      <div class="mb-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="(stat, index) in studentStats" :key="stat.label" v-reveal="{ delay: index * 80 }" class="text-center">
          <div class="text-3xl font-extrabold sm:text-4xl">{{ stat.value }}</div>
          <div class="mt-1 text-brand-200">{{ stat.label }}</div>
        </div>
      </div>

      <div class="grid gap-8 md:grid-cols-2">
        <div v-reveal class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
          <h3 class="mb-6 text-lg font-semibold">Répartition des débouchés</h3>
          <div class="flex items-center justify-center gap-8">
            <div
              class="relative h-40 w-40 shrink-0 rounded-full"
              :style="{ background: donutGradient }"
            >
              <div class="absolute inset-3 flex items-center justify-center rounded-full bg-brand-950">
                <PieChartIcon class="h-8 w-8 text-brand-300" />
              </div>
            </div>
            <ul class="space-y-2 text-sm">
              <li v-for="stat in studentStats" :key="stat.label" class="flex items-center gap-2.5">
                <span class="h-2.5 w-2.5 rounded-full" :style="{ backgroundColor: stat.color }" />
                {{ stat.label }} — {{ stat.value }}
              </li>
            </ul>
          </div>
        </div>

        <div v-reveal="{ delay: 100 }" class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
          <h3 class="mb-6 text-lg font-semibold">Évolution des carrières</h3>
          <div class="flex h-40 items-end justify-center gap-3">
            <div
              v-for="(bar, index) in careerBars"
              :key="index"
              class="w-9 rounded-t-lg bg-brand-gradient transition-all duration-700"
              :style="{ height: `${bar}%` }"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import {
  BarChart3Icon,
  BrainIcon,
  CheckIcon,
  CodeIcon,
  CpuIcon,
  DatabaseIcon,
  DownloadIcon,
  FlaskConicalIcon,
  GraduationCapIcon,
  PieChartIcon,
  QuoteIcon,
  SettingsIcon,
} from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const cursusScience = [
  'Deux ans de tronc commun',
  "Diplôme de Licence Science de l'Ingénieur",
  "Master recherche en Science de l'Ingénieur",
  'Approche généraliste et recherche',
]

const cursusIngenieur = [
  'Deux ans de tronc commun',
  'Spécialisation après la 3ème année',
  "Diplôme d'Ingénieur de conception",
  'Approche technique et applicative',
]

const sdiaSkills = [
  'Machine Learning avancé',
  'Traitement du langage naturel',
  'Vision par ordinateur',
  'Big Data et Hadoop',
  'Deep Learning',
  'Analyse statistique',
]

const metiers = [
  { title: 'AI Researcher', role: 'Recherche en intelligence artificielle', sector: 'Recherche & Développement', icon: BrainIcon },
  { title: 'Data Scientist', role: 'Analyse et modélisation des données', sector: 'Tous secteurs confondus', icon: DatabaseIcon },
  { title: 'Data Analyst', role: 'Analyse business intelligence', sector: 'Finance, Marketing, Santé', icon: BarChart3Icon },
  { title: 'Machine Learning Engineer', role: 'Déploiement de modèles IA', sector: 'Technologie & Industrie', icon: CpuIcon },
  { title: 'Ingénieur IA', role: 'Développement solutions IA', sector: 'Entreprises technologiques', icon: CodeIcon },
  { title: 'Chief Data Officer', role: 'Stratégie données entreprise', sector: 'Direction générale', icon: BrainIcon },
]

const studentStats = [
  { value: '45%', label: "Poursuite à l'étranger", color: '#36b3f5' },
  { value: '25%', label: 'Doctorat', color: '#0079c4' },
  { value: '20%', label: 'Industrie', color: '#7ccdfb' },
  { value: '10%', label: 'Enseignement', color: '#0c446c' },
]

const careerBars = [55, 75, 40, 65, 90]

const donutGradient = computed(() => {
  let acc = 0
  const stops = studentStats.map((stat) => {
    const value = parseFloat(stat.value)
    const start = acc
    acc += value
    return `${stat.color} ${start}% ${acc}%`
  })
  return `conic-gradient(${stops.join(', ')})`
})
</script>
