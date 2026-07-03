<template>
  <div class="flex min-h-screen flex-col bg-white text-slate-700">
    <a
      href="#main-content"
      class="sr-only z-[100] rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white focus:not-sr-only focus:fixed focus:left-4 focus:top-4"
    >
      Aller au contenu
    </a>

    <header
      class="sticky top-0 z-50 border-b transition-all duration-300"
      :class="scrolled ? 'border-brand-100 bg-white/90 shadow-soft backdrop-blur-xl' : 'border-transparent bg-white/70 backdrop-blur-sm'"
    >
      <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <Link href="/" class="group flex shrink-0 items-center gap-2.5 rounded-xl py-1 sm:gap-3">
          <img
            src="/images/logos/logo-club.jpeg"
            alt="Logo Club IA ENSPD"
            class="h-11 w-11 rounded-xl object-cover ring-1 ring-brand-100 transition-transform duration-300 group-hover:scale-105 sm:h-12 sm:w-12"
          />
          <div class="leading-tight">
            <p class="text-sm font-extrabold tracking-tight text-slate-900 sm:text-base">Club IA ENSPD</p>
            <p class="text-[11px] font-medium text-brand-600 sm:text-xs">Former • Développer • Sensibiliser</p>
          </div>
        </Link>

        <nav class="hidden items-center gap-0.5 xl:flex">
          <Link
            v-for="item in navigation"
            :key="item.name"
            :href="item.href"
            class="relative rounded-lg px-3.5 py-2 text-sm font-semibold transition-colors duration-200"
            :class="isActive(item.href) ? 'text-brand-700' : 'text-slate-600 hover:text-brand-700'"
          >
            {{ item.name }}
            <span
              class="absolute inset-x-3 -bottom-[1px] h-0.5 rounded-full bg-brand-gradient transition-transform duration-300 ease-smooth"
              :class="isActive(item.href) ? 'scale-x-100' : 'scale-x-0'"
            />
          </Link>
        </nav>

        <div class="flex items-center gap-2">
          <Link
            href="/collecte-donnees"
            class="hidden rounded-xl bg-brand-gradient px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:shadow-card-hover sm:inline-flex"
          >
            Participer
          </Link>

          <button
            type="button"
            class="btn-icon xl:hidden"
            :aria-expanded="mobileMenuOpen"
            aria-label="Ouvrir le menu de navigation"
            @click="mobileMenuOpen = !mobileMenuOpen"
          >
            <component :is="mobileMenuOpen ? XIcon : MenuIcon" class="h-5 w-5" />
          </button>
        </div>
      </div>

      <Transition
        enter-active-class="transition-all duration-300 ease-smooth"
        leave-active-class="transition-all duration-200 ease-in"
        enter-from-class="opacity-0 -translate-y-2"
        leave-to-class="opacity-0 -translate-y-2"
      >
        <div v-if="mobileMenuOpen" class="border-t border-brand-100 bg-white xl:hidden">
          <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4 sm:px-6">
            <Link
              v-for="item in navigation"
              :key="item.name"
              :href="item.href"
              class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors duration-200"
              :class="isActive(item.href) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700'"
              @click="mobileMenuOpen = false"
            >
              <component :is="item.icon" class="h-4.5 w-4.5 shrink-0 opacity-70" />
              {{ item.name }}
            </Link>

            <Link
              href="/collecte-donnees"
              class="mt-2 flex items-center justify-center gap-2 rounded-xl bg-brand-gradient px-4 py-3 text-sm font-semibold text-white shadow-soft"
              @click="mobileMenuOpen = false"
            >
              Participer à la collecte
            </Link>

            <div class="mt-4 flex flex-wrap gap-2 border-t border-brand-100 pt-4">
              <a
                v-for="social in socials"
                :key="social.name"
                :href="social.href"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-icon"
                :aria-label="social.name"
              >
                <component :is="social.icon" class="h-4 w-4" />
              </a>
            </div>
          </nav>
        </div>
      </Transition>
    </header>

    <main id="main-content" class="flex-1">
      <Transition name="page-transition" mode="out-in" appear>
        <div :key="page.url">
          <slot />
        </div>
      </Transition>
    </main>

    <footer class="border-t border-brand-100 bg-gradient-to-b from-brand-950 to-slate-950 text-slate-300">
      <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1.3fr_0.7fr_0.7fr_0.9fr]">
          <div>
            <div class="flex items-center gap-2.5">
              <img src="/images/logos/logo-club.jpeg" alt="Logo Club IA ENSPD" class="h-10 w-10 rounded-lg object-cover ring-1 ring-white/10" />
              <p class="text-sm font-bold uppercase tracking-[0.3em] text-brand-300">Club IA ENSPD</p>
            </div>
            <p class="mt-5 max-w-sm text-sm leading-7 text-slate-400">
              Une communauté d'étudiants, de chercheurs et de passionnés qui met l'intelligence artificielle au service de
              projets concrets, formateurs et porteurs d'impact.
            </p>
          </div>

          <div>
            <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Navigation</h4>
            <ul class="mt-4 space-y-2.5 text-sm">
              <li v-for="item in navigation.slice(0, 5)" :key="item.name">
                <Link :href="item.href" class="text-slate-400 transition-colors duration-200 hover:text-brand-300">{{ item.name }}</Link>
              </li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Ressources</h4>
            <ul class="mt-4 space-y-2.5 text-sm">
              <li><Link href="/collecte-donnees" class="text-slate-400 transition-colors duration-200 hover:text-brand-300">Collecte de données</Link></li>
              <li><Link href="/resultats-analyse" class="text-slate-400 transition-colors duration-200 hover:text-brand-300">Résultats &amp; analyse</Link></li>
              <li><Link href="/contact" class="text-slate-400 transition-colors duration-200 hover:text-brand-300">Contact</Link></li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Suivez-nous</h4>
            <div class="mt-4 flex flex-wrap gap-2">
              <a
                v-for="social in socials"
                :key="social.name"
                :href="social.href"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-slate-300 transition-all duration-300 hover:-translate-y-0.5 hover:border-brand-400/40 hover:bg-brand-400/10 hover:text-brand-300"
                :aria-label="social.name"
              >
                <component :is="social.icon" class="h-4 w-4" />
              </a>
            </div>
          </div>
        </div>

        <div class="mt-12 flex flex-col gap-3 border-t border-white/10 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
          <p>&copy; {{ new Date().getFullYear() }} Club Intelligence Artificielle — ENSPD. Tous droits réservés.</p>
          <p class="flex items-center gap-1.5">
            Conçu avec
            <HeartIcon class="h-3.5 w-3.5 fill-brand-400 text-brand-400" />
            par le Club IA
          </p>
        </div>
      </div>
    </footer>

    <FlashToast />
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref } from 'vue'
import FlashToast from '@/Components/FlashToast.vue'
import {
  FacebookIcon,
  GraduationCapIcon,
  HeartIcon,
  HomeIcon,
  InstagramIcon,
  LineChartIcon,
  MailIcon,
  MenuIcon,
  NewspaperIcon,
  SendIcon,
  TargetIcon,
  TrophyIcon,
  TwitterIcon,
  XIcon,
  YoutubeIcon,
} from 'lucide-vue-next'

const mobileMenuOpen = ref(false)
const scrolled = ref(false)
const page = usePage()

const isActive = (href) => {
  if (href === '/') {
    return page.url === href
  }

  return page.url.startsWith(href)
}

const navigation = [
  { name: 'Accueil', href: '/', icon: HomeIcon },
  { name: 'Espace Étudiant', href: '/espace-etudiant', icon: GraduationCapIcon },
  { name: 'Actualité', href: '/actualite', icon: NewspaperIcon },
  { name: 'Nos Objectifs', href: '/objectifs', icon: TargetIcon },
  { name: 'Nos Réalisations', href: '/realisations', icon: TrophyIcon },
  { name: 'Collecte de données', href: '/collecte-donnees', icon: SendIcon },
  { name: 'Résultat Analyse', href: '/resultats-analyse', icon: LineChartIcon },
  { name: 'Contact', href: '/contact', icon: MailIcon },
]

const socials = [
  { name: 'Facebook', href: 'https://www.facebook.com/profile.php?id=61585659006581', icon: FacebookIcon },
  { name: 'Instagram', href: 'https://www.instagram.com/clubiaenspd?utm_source=qr&igsh=Z3Vnd2tiNW9qY2hj', icon: InstagramIcon },
  { name: 'X', href: 'https://x.com/clubia_enspd', icon: TwitterIcon },
  { name: 'YouTube', href: 'https://youtube.com/@clubia-enspd?si=_FchjOZt46t7VjRn', icon: YoutubeIcon },
]

const handleScroll = () => {
  scrolled.value = window.scrollY > 8
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.page-transition-enter-active {
  transition: opacity 0.35s cubic-bezier(0.22, 1, 0.36, 1), transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.page-transition-leave-active {
  transition: opacity 0.15s ease-in;
}
.page-transition-enter-from {
  opacity: 0;
  transform: translateY(8px);
}
.page-transition-leave-to {
  opacity: 0;
}
</style>
