<template>
  <div class="text-slate-800">
    <section class="relative isolate overflow-hidden bg-gradient-to-br from-white via-sky-50 to-blue-50">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.25),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(37,99,235,0.18),_transparent_28%)]"></div>
      <div class="absolute inset-0 opacity-50 [background-image:radial-gradient(rgba(14,116,144,0.14)_1px,transparent_1px)] [background-size:24px_24px]"></div>
      <div class="absolute left-[-8%] top-[-10%] h-72 w-72 rounded-full bg-sky-300/30 blur-3xl"></div>
      <div class="absolute bottom-[-12%] right-[-8%] h-80 w-80 rounded-full bg-blue-400/20 blur-3xl"></div>

      <div class="relative mx-auto grid max-w-7xl gap-12 px-4 pb-24 pt-24 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8 lg:pb-32 lg:pt-32">
        <div class="max-w-3xl animate-fade-in-up" v-reveal>
          <div class="mb-6 flex flex-wrap items-center gap-3">
            <div class="inline-flex items-center gap-3 rounded-full border border-sky-100 bg-white/90 px-4 py-2 text-sm font-medium text-sky-700 shadow-sm backdrop-blur-xl">
              <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(74,222,128,0.9)]"></span>
              Innovation • IA • Impact social
            </div>
            <div class="flex items-center gap-3 rounded-full border border-sky-100 bg-white/90 px-3 py-2 shadow-sm backdrop-blur-xl">
              <img src="/images/logos/logo-club.jpeg" alt="Logo Club IA ENSPD" class="h-10 w-10 rounded-full object-cover ring-2 ring-sky-100" />
              <img src="/images/logos/logo-ecole.jpeg" alt="Logo ENSPD" class="h-10 w-10 rounded-full object-cover ring-2 ring-sky-100" />
            </div>
          </div>

          <h1 class="text-4xl font-black leading-tight text-slate-900 sm:text-5xl lg:text-7xl">
            <span class="block">Club IA</span>
            <span class="mt-3 block text-sky-600">ENSPD</span>
          </h1>

          <p class="mt-8 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl">
            Une communauté d’étudiants, de chercheurs et de passionnés qui transforme l’intelligence artificielle en projets concrets, utiles et ambitieux.
          </p>

          <div class="mt-10 flex flex-col gap-4 sm:flex-row">
            <Link
              href="/espace-etudiant"
              class="group inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 px-7 py-4 text-base font-semibold text-white shadow-[0_20px_40px_rgba(14,165,233,0.3)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_25px_45px_rgba(14,165,233,0.35)]"
            >
              Rejoindre l’aventure
              <ArrowRightIcon class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" />
            </Link>
            <a
              href="#realisations"
              class="inline-flex items-center justify-center rounded-2xl border border-sky-200 bg-white px-7 py-4 text-base font-semibold text-sky-700 transition-all duration-300 hover:-translate-y-1 hover:border-sky-300 hover:bg-sky-50"
            >
              Découvrir nos réalisations
            </a>
          </div>

          <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div
              v-for="(stat, index) in statsData"
              :key="stat.label"
              v-reveal
              :style="{ transitionDelay: `${index * 80}ms` }"
              class="rounded-2xl border border-sky-100 bg-white/90 p-4 text-left shadow-[0_14px_40px_rgba(14,116,144,0.08)] backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:border-sky-300"
            >
              <div class="mb-3 inline-flex rounded-xl bg-sky-500/10 p-2 text-sky-600">
                <component :is="statIcons[index % statIcons.length]" class="h-4 w-4" />
              </div>
              <div class="text-2xl font-bold text-slate-900">{{ stat.value }}</div>
              <div class="mt-1 text-sm text-slate-600">{{ stat.label }}</div>
            </div>
          </div>
        </div>

        <div class="animate-fade-in-up-delayed rounded-[2rem] border border-sky-200/80 bg-white/90 p-6 shadow-[0_30px_80px_rgba(14,116,144,0.12)] backdrop-blur-xl sm:p-8" v-reveal>
          <div class="rounded-[1.5rem] border border-sky-100 bg-slate-50 p-6">
            <div class="flex items-center gap-3">
              <div class="rounded-xl bg-sky-500/10 p-2 text-sky-600">
                <CpuIcon class="h-5 w-5" />
              </div>
              <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">Notre approche</p>
                <p class="text-lg font-semibold text-slate-900">Formations • Projets • Écosystème IA</p>
              </div>
            </div>

            <div class="mt-6 space-y-4">
              <div class="flex items-start gap-3 rounded-2xl border border-sky-100 bg-white p-4 shadow-sm">
                <SparklesIcon class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" />
                <div>
                  <p class="font-semibold text-slate-900">Innovation concrète</p>
                  <p class="mt-1 text-sm text-slate-600">Des projets pensés pour répondre à des besoins réels et à fort impact.</p>
                </div>
              </div>
              <div class="flex items-start gap-3 rounded-2xl border border-sky-100 bg-white p-4 shadow-sm">
                <UsersIcon class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" />
                <div>
                  <p class="font-semibold text-slate-900">Communauté engagée</p>
                  <p class="mt-1 text-sm text-slate-600">Un réseau de talents qui apprend, collabore et partage ses compétences.</p>
                </div>
              </div>
              <div class="flex items-start gap-3 rounded-2xl border border-sky-100 bg-white p-4 shadow-sm">
                <BadgeCheckIcon class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" />
                <div>
                  <p class="font-semibold text-slate-900">Excellence et sérieux</p>
                  <p class="mt-1 text-sm text-slate-600">Un cadre structuré pour mener des initiatives ambitieuses jusqu’au bout.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-gradient-to-br from-slate-50 via-white to-sky-50 py-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center" v-reveal>
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Univers du Club</p>
          <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Découvrez les moments qui façonnent notre identité</h2>
          <p class="mx-auto mt-4 max-w-3xl text-lg text-slate-600">Chaque image raconte un chapitre de notre parcours, de nos ateliers à nos plus belles réussites.</p>
        </div>

        <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_25px_80px_rgba(15,23,42,0.08)]" v-reveal>
          <div class="relative h-[420px] overflow-hidden sm:h-[520px] lg:h-[620px]">
            <transition name="carousel-fade" mode="out-in">
              <div v-if="currentSlide" :key="currentSlideIndex" class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-700/70 via-blue-700/55 to-slate-900/40"></div>
                <img v-if="currentSlide.image_url" :src="currentSlide.image_url" :alt="currentSlide.caption" class="h-full w-full object-cover opacity-90" />
                <div class="absolute inset-0 bg-[linear-gradient(120deg,rgba(15,23,42,0.45),rgba(15,23,42,0.12))]"></div>
                <div class="relative z-10 flex h-full items-center justify-center px-6 text-center text-white sm:px-10">
                  <div class="max-w-4xl">
                    <div class="mb-6 inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-xl">Moment phare</div>
                    <h3 class="text-3xl font-bold text-white [text-shadow:0_2px_12px_rgba(0,0,0,0.45)] sm:text-4xl lg:text-5xl">
                      {{ currentSlide.caption || 'Sans titre' }}
                    </h3>
                    <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-100 [text-shadow:0_1px_8px_rgba(0,0,0,0.4)] sm:text-xl">
                      {{ currentSlide.description || 'Aucune description fournie pour ce slide.' }}
                    </p>
                    <button class="mt-8 rounded-2xl border border-white/20 bg-white/10 px-6 py-3 font-semibold backdrop-blur-xl transition-all duration-300 hover:bg-white/20">Explorer</button>
                  </div>
                </div>
              </div>
            </transition>
          </div>

          <button v-if="carouselData.length > 1" @click="prevSlide" class="absolute left-4 top-1/2 z-20 -translate-y-1/2 rounded-2xl border border-white/20 bg-white/10 p-3 text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/20" aria-label="Slide précédent">
            <ChevronLeftIcon class="h-5 w-5" />
          </button>
          <button v-if="carouselData.length > 1" @click="nextSlide" class="absolute right-4 top-1/2 z-20 -translate-y-1/2 rounded-2xl border border-white/20 bg-white/10 p-3 text-white backdrop-blur-xl transition-all duration-300 hover:bg-white/20" aria-label="Slide suivant">
            <ChevronRightIcon class="h-5 w-5" />
          </button>

          <div v-if="carouselData.length > 1" class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 gap-2">
            <button v-for="(slide, index) in carouselData" :key="slide.caption + index" @click="setCurrentSlide(index)" class="h-2.5 rounded-full transition-all duration-300" :class="currentSlideIndex === index ? 'w-8 bg-white' : 'w-2.5 bg-white/50'" />
          </div>
        </div>
      </div>
    </section>

    <section class="bg-gradient-to-br from-sky-50 via-white to-blue-50 py-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center" v-reveal>
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Présidence</p>
          <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Le mot du président</h2>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-sky-200 bg-gradient-to-br from-white via-sky-50 to-blue-50 p-8 shadow-[0_30px_80px_rgba(15,23,42,0.08)] sm:p-10 lg:p-12" v-reveal>
          <div class="grid gap-10 lg:grid-cols-[0.7fr_1.3fr] lg:items-center">
            <div class="relative mx-auto w-full max-w-[260px] rounded-[2rem] border border-sky-100 bg-white/80 p-6 shadow-sm backdrop-blur-xl">
              <div class="flex aspect-square items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-sky-500 to-blue-600 text-5xl font-bold text-white shadow-2xl">
                <MessageSquareTextIcon class="h-16 w-16" />
              </div>
              <div class="mt-4 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">Président</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ presidentData.name }}</p>
              </div>
            </div>
            <div>
              <div class="mb-6 inline-flex items-center rounded-full border border-sky-100 bg-white/80 px-4 py-2 text-sm font-medium text-sky-700 shadow-sm backdrop-blur-xl">Mission • Formation • Développement</div>
              <blockquote class="text-xl leading-9 text-slate-700 sm:text-2xl">
                “Porté à la tête de la gestion du club, mon comité exécutif et moi-même nous donnons pour mission et devise : <span class="font-semibold text-sky-600">Former, Développer, Sensibiliser</span>. Ensemble, bâtissons l’avenir de l’intelligence artificielle en Afrique.”
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="equipe" class="bg-gradient-to-br from-slate-50 to-sky-50 py-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center" v-reveal>
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Bureau</p>
          <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Notre équipe dirigeante au service de l’innovation</h2>
          <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">Des profils engagés, complémentaires et passionnés, qui donnent vie à chaque initiative du club.</p>
        </div>

        <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_24px_80px_rgba(15,23,42,0.08)] sm:p-8 lg:p-10" v-reveal>
          <div class="overflow-hidden rounded-[1.6rem] border border-slate-200 bg-slate-50">
            <transition name="member-fade" mode="out-in">
              <div v-if="currentTeamMember" :key="currentTeamMember.name" class="grid lg:grid-cols-[0.8fr_1.2fr]">
                <div class="relative aspect-[4/5] overflow-hidden bg-slate-200 lg:aspect-auto">
                  <img :src="resolvePhoto(currentTeamMember)" :alt="currentTeamMember.name" class="h-full w-full object-cover" />
                  <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                </div>
                <div class="flex flex-col justify-center p-8 sm:p-10 lg:p-12">
                  <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">{{ currentTeamMember.position }}</p>
                  <h3 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">{{ currentTeamMember.name }}</h3>
                  <p class="mt-4 text-base leading-8 text-slate-600">{{ currentTeamMember.bio }}</p>
                  <div class="mt-8 inline-flex w-fit items-center rounded-full border border-sky-100 bg-sky-50 px-4 py-2 text-sm font-medium text-sky-700">Membre du bureau</div>
                </div>
              </div>
            </transition>
          </div>

          <div v-if="executiveMembersData.length > 1" class="mt-8 flex flex-wrap items-center justify-between gap-4">
            <div class="flex gap-2">
              <button v-for="(member, index) in executiveMembersData" :key="member.name" @click="setTeamSlide(index)" class="h-2.5 rounded-full transition-all duration-300" :class="teamCarouselIndex === index ? 'w-8 bg-sky-600' : 'w-2.5 bg-slate-300'" />
            </div>
            <div class="flex gap-3">
              <button @click="prevTeam" class="rounded-2xl border border-slate-200 bg-white p-3 text-slate-700 transition-all duration-300 hover:border-sky-300 hover:text-sky-700" aria-label="Membre précédent">
                <ChevronLeftIcon class="h-5 w-5" />
              </button>
              <button @click="nextTeam" class="rounded-2xl border border-slate-200 bg-white p-3 text-slate-700 transition-all duration-300 hover:border-sky-300 hover:text-sky-700" aria-label="Membre suivant">
                <ChevronRightIcon class="h-5 w-5" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="realisations" class="bg-gradient-to-br from-slate-50 via-sky-50 to-white py-20 text-slate-800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center" v-reveal>
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Réalisation phare</p>
          <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">Le projet qui incarne notre excellence</h2>
          <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">Une initiative pensée pour montrer la valeur de l’IA au service de l’innovation et du développement.</p>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-sky-200 bg-gradient-to-br from-white via-sky-50 to-blue-50 p-6 shadow-[0_30px_80px_rgba(14,116,144,0.10)] backdrop-blur-xl sm:p-8 lg:p-10" v-reveal>
          <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <div class="overflow-hidden rounded-[1.5rem] bg-slate-900 shadow-2xl">
              <div class="aspect-video bg-gradient-to-br from-sky-500 via-blue-600 to-slate-900 p-10">
                <div v-if="!bestAchievementData.image_url" class="flex h-full items-center justify-center rounded-[1.2rem] border border-white/10 bg-white/10">
                  <RocketIcon class="h-20 w-20 text-white/80" />
                </div>
                <img v-else :src="bestAchievementData.image_url" :alt="bestAchievementData.title" class="h-full w-full object-cover" />
              </div>
            </div>
            <div>
              <div class="inline-flex rounded-full border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700">{{ bestAchievementData.category || 'Innovation' }}</div>
              <h3 class="mt-6 text-3xl font-bold text-slate-900 sm:text-4xl">{{ bestAchievementData.title }}</h3>
              <p class="mt-5 text-lg leading-8 text-slate-600">{{ bestAchievementData.description }}</p>
              <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                <Link :href="bestAchievementData.link || '#'" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 px-7 py-4 font-semibold text-white transition-all duration-300 hover:-translate-y-1">Découvrir le projet</Link>
                <button class="inline-flex items-center justify-center rounded-2xl border border-sky-200 bg-white px-7 py-4 font-semibold text-sky-700 transition-all duration-300 hover:bg-sky-50">Télécharger</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref } from 'vue'
import {
  ArrowRightIcon,
  BadgeCheckIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
  CpuIcon,
  MessageSquareTextIcon,
  RocketIcon,
  SparklesIcon,
  UsersIcon,
} from 'lucide-vue-next'

const props = defineProps({
  carouselSlides: Array,
  bestAchievement: Object,
  stats: Array,
  executiveMembers: Array,
  president: Object,
})

const defaultStats = [
  { value: '50+', label: 'Projets Innovants' },
  { value: '200+', label: 'Membres Actifs' },
  { value: '15+', label: 'Partenariats' },
  { value: '98%', label: 'Satisfaction' },
]

const defaultExecutiveMembers = [
  {
    name: 'Dr. Jean Dupont',
    position: 'Président',
    bio: 'Expert en Machine Learning avec 8 ans d’expérience dans le domaine de l’IA.',
  },
  {
    name: 'Prof. Marie Lambert',
    position: 'Vice-Présidente',
    bio: 'Spécialiste en vision par ordinateur et traitement d’images médicales.',
  },
  {
    name: 'M. Paul Martin',
    position: 'Secrétaire Général',
    bio: 'Responsable de la coordination des projets et de la communication internationale.',
  },
  {
    name: 'Mme. Sophie Leroy',
    position: 'Trésorière',
    bio: 'Gestionnaire des ressources et financements des projets innovants du club.',
  },
]

const defaultBestAchievement = {
  title: 'Système de Diagnostic Médical Intelligent',
  category: 'Santé & Innovation',
  description: 'Développement d’une plateforme IA révolutionnaire pour le diagnostic précoce des maladies tropicales. Notre système combine vision par ordinateur et deep learning pour analyser les images médicales avec une précision de 95%.',
  link: '/realisations/projet-medical',
  image_url: null,
}

const defaultCarouselSlides = [
  {
    caption: 'Bienvenue à ENSPD',
    description: 'Découvrez notre campus et les espaces dédiés à la recherche et à l’innovation.',
    image_url: null,
  },
  {
    caption: 'Ateliers collaboratifs',
    description: 'Des sessions de travail où idées, techniques et créativité se rencontrent.',
    image_url: null,
  },
  {
    caption: 'Compétitions IA',
    description: 'Une communauté qui s’exprime, apprend et se distingue à travers des défis concrets.',
    image_url: null,
  },
]

const normalizeCarouselSlide = (slide = {}) => {
  const title = slide.caption || slide.title || slide.titre || ''

  return {
    caption: title,
    title,
    titre: title,
    description: slide.description || '',
    image_url: slide.image_url || '',
  }
}

const carouselData = computed(() => {
  const slides = Array.isArray(props.carouselSlides)
    ? props.carouselSlides.map(normalizeCarouselSlide).filter((slide) => slide.caption || slide.description || slide.image_url)
    : []

  return slides.length > 0 ? slides : defaultCarouselSlides
})

const bestAchievementData = props.bestAchievement || defaultBestAchievement
const statsData = computed(() => (props.stats && props.stats.length > 0 ? props.stats : defaultStats))
const executiveMembersData = computed(() => (props.executiveMembers && props.executiveMembers.length > 0 ? props.executiveMembers : defaultExecutiveMembers))
const presidentData = computed(() => props.president || { name: 'Dr. Jean Dupont' })
const statIcons = [SparklesIcon, CpuIcon, UsersIcon, BadgeCheckIcon]

const currentSlideIndex = ref(0)
const teamCarouselIndex = ref(0)
let carouselInterval = null
let teamInterval = null

const currentSlide = computed(() => {
  const slides = carouselData.value
  if (!slides.length) return null

  return slides[currentSlideIndex.value % slides.length]
})

const setCurrentSlide = (index) => {
  currentSlideIndex.value = index
}

const nextSlide = () => {
  if (carouselData.value.length > 0) {
    currentSlideIndex.value = (currentSlideIndex.value + 1) % carouselData.value.length
  }
}

const prevSlide = () => {
  if (carouselData.value.length > 0) {
    currentSlideIndex.value = (currentSlideIndex.value - 1 + carouselData.value.length) % carouselData.value.length
  }
}

const currentTeamMember = computed(() => {
  const members = executiveMembersData.value
  if (!members.length) return null

  return members[teamCarouselIndex.value % members.length]
})

const resolvePhoto = (member) => member?.photo_url || '/images/membres/default-member.svg'

const setTeamSlide = (index) => {
  teamCarouselIndex.value = index
}

const nextTeam = () => {
  if (executiveMembersData.value.length > 0) {
    teamCarouselIndex.value = (teamCarouselIndex.value + 1) % executiveMembersData.value.length
  }
}

const prevTeam = () => {
  if (executiveMembersData.value.length > 0) {
    teamCarouselIndex.value = (teamCarouselIndex.value - 1 + executiveMembersData.value.length) % executiveMembersData.value.length
  }
}

onMounted(() => {
  if (carouselData.value.length > 1) {
    carouselInterval = setInterval(nextSlide, 7000)
  }

  if (executiveMembersData.value.length > 1) {
    teamInterval = setInterval(nextTeam, 5500)
  }
})

onUnmounted(() => {
  if (carouselInterval) {
    clearInterval(carouselInterval)
  }

  if (teamInterval) {
    clearInterval(teamInterval)
  }
})
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(28px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUpDelayed {
  from {
    opacity: 0;
    transform: translateY(36px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.carousel-fade-enter-active,
.carousel-fade-leave-active {
  transition: all 800ms cubic-bezier(0.22, 1, 0.36, 1);
}

.carousel-fade-enter-from,
.carousel-fade-leave-to {
  opacity: 0;
  transform: translateX(24px) scale(0.98);
}

.carousel-fade-enter-to,
.carousel-fade-leave-from {
  opacity: 1;
  transform: translateX(0) scale(1);
}

.member-fade-enter-active,
.member-fade-leave-active {
  transition: all 800ms cubic-bezier(0.22, 1, 0.36, 1);
}

.member-fade-enter-from,
.member-fade-leave-to {
  opacity: 0;
  transform: translateX(24px) scale(0.98);
}

.member-fade-enter-to,
.member-fade-leave-from {
  opacity: 1;
  transform: translateX(0) scale(1);
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out both;
}

.animate-fade-in-up-delayed {
  animation: fadeInUpDelayed 1.05s ease-out both;
}
</style>
