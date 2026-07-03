<template>
  <PageHero
    eyebrow="Contact"
    title="Restons connectés"
    subtitle="Pour construire l'avenir de l'intelligence artificielle ensemble"
  />

  <!-- Canaux de communication -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">
          <PhoneIcon class="h-3.5 w-3.5" />
          Canaux
        </span>
        <h2 class="section-title">Canaux de communication</h2>
      </div>

      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div v-for="(channel, index) in canaux" :key="channel.id" v-reveal="{ delay: index * 90 }" class="surface-card-hover group p-6 text-center">
          <div class="icon-tile mx-auto mb-4">
            <component :is="channel.icon" class="h-6 w-6" />
          </div>
          <h3 class="mb-2 text-lg font-bold text-slate-900">{{ channel.nom }}</h3>
          <p class="mb-3 text-sm leading-6 text-slate-500">{{ channel.description }}</p>
          <p class="mb-4 flex items-center justify-center gap-1.5 text-xs font-semibold text-brand-600">
            <ClockIcon class="h-3.5 w-3.5" />
            {{ channel.delai }}
          </p>
          <a :href="channel.lien" target="_blank" rel="noopener noreferrer" class="btn-primary btn-sm w-full">Contacter</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Annonce officielle -->
  <section class="bg-brand-50/50 py-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="surface-card overflow-hidden">
        <div class="flex items-center gap-3 bg-brand-gradient px-6 py-4">
          <MegaphoneIcon class="h-5 w-5 text-white" />
          <h3 class="font-bold text-white">Annonce officielle</h3>
        </div>
        <div class="p-6 sm:p-8">
          <p class="whitespace-pre-line leading-8 text-slate-700">{{ annonce }}</p>
        </div>
      </div>
    </div>
  </section>
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid gap-10 lg:grid-cols-[1fr_1.3fr] lg:gap-14">
        <div v-reveal>
          <span class="section-eyebrow">
            <SendIcon class="h-3.5 w-3.5" />
            Écrivez-nous
          </span>
          <h2 class="section-title !mt-4 text-left">Envoyez-nous un message</h2>
          <p class="mt-4 leading-7 text-slate-500">
            Une question, une idée de projet, une envie de rejoindre le club ? Remplissez le formulaire, votre message
            s'ouvrira directement dans votre messagerie prêt à être envoyé.
          </p>

          <div class="mt-8 space-y-4">
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <MapPinIcon class="h-5 w-5 shrink-0 text-brand-500" />
              Campus ENSPD, PK17 — Douala, Cameroun
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <CalendarIcon class="h-5 w-5 shrink-0 text-brand-500" />
              Réunions tous les samedis, 10h – 12h
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <MailIcon class="h-5 w-5 shrink-0 text-brand-500" />
              contact@clubia-enspd.cm
            </div>
          </div>
        </div>

        <form v-reveal="{ delay: 120 }" class="surface-card space-y-5 p-6 sm:p-8" @submit.prevent="submitForm">
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="field-label">Prénom *</label>
              <input v-model="formData.prenom" type="text" required class="field-input" placeholder="Votre prénom" />
            </div>
            <div>
              <label class="field-label">Nom *</label>
              <input v-model="formData.nom" type="text" required class="field-input" placeholder="Votre nom" />
            </div>
          </div>

          <div>
            <label class="field-label">Email *</label>
            <input v-model="formData.email" type="email" required class="field-input" placeholder="vous@exemple.com" />
          </div>

          <div>
            <label class="field-label">Sujet *</label>
            <input v-model="formData.sujet" type="text" required class="field-input" placeholder="Objet de votre message" />
          </div>

          <div>
            <label class="field-label">Message *</label>
            <textarea v-model="formData.message" rows="5" required class="field-input" placeholder="Écrivez votre message ici…" />
          </div>

          <button type="submit" class="btn-primary w-full">
            <SendIcon class="h-4.5 w-4.5" />
            Envoyer le message
          </button>

          <Transition
            enter-active-class="transition-all duration-300"
            enter-from-class="opacity-0 -translate-y-2"
          >
            <p v-if="submitted" class="flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
              <CheckCircle2Icon class="h-4.5 w-4.5 shrink-0" />
              Votre messagerie s'est ouverte avec votre message pré-rempli — il ne reste qu'à l'envoyer !
            </p>
          </Transition>
        </form>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="bg-white py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-14 max-w-2xl text-center">
        <span class="section-eyebrow">
          <HelpCircleIcon class="h-3.5 w-3.5" />
          FAQ
        </span>
        <h2 class="section-title">Questions fréquentes</h2>
      </div>

      <div class="space-y-3">
        <div v-for="(faq, index) in faqs" :key="faq.id" v-reveal="{ delay: index * 80 }" class="surface-card overflow-hidden">
          <button
            type="button"
            class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left"
            @click="openFaq = openFaq === faq.id ? null : faq.id"
          >
            <span class="font-semibold text-slate-900">{{ faq.question }}</span>
            <ChevronDownIcon class="h-5 w-5 shrink-0 text-brand-500 transition-transform duration-300" :class="{ 'rotate-180': openFaq === faq.id }" />
          </button>
          <Transition
            enter-active-class="transition-all duration-300 ease-smooth"
            leave-active-class="transition-all duration-200 ease-in"
            enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-40 opacity-100"
            leave-from-class="max-h-40 opacity-100"
            leave-to-class="max-h-0 opacity-0"
          >
            <div v-if="openFaq === faq.id" class="overflow-hidden px-6 pb-5">
              <p class="text-sm leading-7 text-slate-500">{{ faq.reponse }}</p>
            </div>
          </Transition>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import {
  CalendarIcon,
  CheckCircle2Icon,
  ChevronDownIcon,
  ClockIcon,
  FacebookIcon,
  GithubIcon,
  HelpCircleIcon,
  InstagramIcon,
  MailIcon,
  MapPinIcon,
  MegaphoneIcon,
  MessageCircleIcon,
  PhoneIcon,
  SendIcon,
  TwitterIcon,
  YoutubeIcon,
} from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const formData = ref({
  prenom: '',
  nom: '',
  email: '',
  sujet: '',
  message: '',
})

const submitted = ref(false)
const openFaq = ref(null)

const annonce = `🎉🎉🎉 Vous pouvez désormais suivre l'intégralité de l'actualité 🌐 du CIA sur nos plateformes :
--- GitHub : https://github.com/ClubIntelligenceArtificielle
--- Instagram : https://www.instagram.com/clubiaenspd?utm_source=qr&igsh=Z3Vnd2tiNW9qY2hj
--- Facebook : https://www.facebook.com/profile.php?id=61585659006581
--- Chaîne YouTube : https://youtube.com/@clubia-enspd?si=_FchjOZt46t7VjRn
--- Chaîne Telegram : https://t.me/Club_IA_ENSPD
--- X (Twitter) : https://x.com/clubia_enspd
--- Chaîne WhatsApp : https://whatsapp.com/channel/0029Vb9p1ldAojYus9XU9r2W

🔥 Surtout n'hésitez pas à vous abonner ✅ et à liker ❤️ nos publications 💯`

const canaux = [
  {
    id: 1,
    nom: 'WhatsApp',
    icon: MessageCircleIcon,
    description: "Suivez l'actualité du CIA en direct",
    delai: 'Chaîne officielle',
    lien: 'https://whatsapp.com/channel/0029Vb9p1ldAojYus9XU9r2W',
  },
  {
    id: 2,
    nom: 'Instagram',
    icon: InstagramIcon,
    description: 'Photos, coulisses et actualités visuelles',
    delai: '@clubiaenspd',
    lien: 'https://www.instagram.com/clubiaenspd?utm_source=qr&igsh=Z3Vnd2tiNW9qY2hj',
  },
  {
    id: 3,
    nom: 'Facebook',
    icon: FacebookIcon,
    description: 'Événements et publications officielles',
    delai: 'Page officielle',
    lien: 'https://www.facebook.com/profile.php?id=61585659006581',
  },
  {
    id: 4,
    nom: 'YouTube',
    icon: YoutubeIcon,
    description: 'Conférences, tutoriels et retours en vidéo',
    delai: 'Chaîne officielle',
    lien: 'https://youtube.com/@clubia-enspd?si=_FchjOZt46t7VjRn',
  },
  {
    id: 5,
    nom: 'Telegram',
    icon: SendIcon,
    description: 'Échanges et annonces communautaires',
    delai: 'Chaîne officielle',
    lien: 'https://t.me/Club_IA_ENSPD',
  },
  {
    id: 6,
    nom: 'X (Twitter)',
    icon: TwitterIcon,
    description: 'Annonces courtes et actualités rapides',
    delai: '@clubia_enspd',
    lien: 'https://x.com/clubia_enspd',
  },
  {
    id: 7,
    nom: 'GitHub',
    icon: GithubIcon,
    description: 'Nos projets et contributions open source',
    delai: 'Organisation officielle',
    lien: 'https://github.com/ClubIntelligenceArtificielle',
  },
  {
    id: 8,
    nom: 'Email',
    icon: MailIcon,
    description: 'Communications formelles et partenariats',
    delai: '48h max',
    lien: 'mailto:contact@clubia-enspd.cm',
  },
]

const faqs = [
  {
    id: 1,
    question: 'Comment rejoindre le club ?',
    reponse: 'Envoyez-nous un message via le formulaire ou WhatsApp avec votre motivation et vos compétences.',
  },
  {
    id: 2,
    question: 'Quand se réunit le club ?',
    reponse: "Tous les samedis de 10h à 12h au campus PK17. Consultez l'agenda pour les événements spéciaux.",
  },
  {
    id: 3,
    question: "Faut-il être expert en IA pour contribuer ?",
    reponse: 'Non ! Tous les niveaux sont les bienvenus. L\'enthousiasme et la motivation sont nos critères principaux.',
  },
]

const submitForm = () => {
  const { prenom, nom, email, sujet, message } = formData.value
  const body = `Nom : ${prenom} ${nom}%0AEmail : ${email}%0A%0A${encodeURIComponent(message)}`
  window.location.href = `mailto:contact@clubia-enspd.cm?subject=${encodeURIComponent(sujet)}&body=${body}`

  submitted.value = true
  setTimeout(() => (submitted.value = false), 6000)
}
</script>
