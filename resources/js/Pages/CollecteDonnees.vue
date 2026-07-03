<template>
  <PageHero
    eyebrow="Contribuer"
    title="Collecte de données"
    subtitle="Contribuez à une intelligence artificielle responsable et adaptée à l'écosystème africain"
  />

  <!-- Introduction -->
  <section class="bg-white py-16">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <p v-reveal class="mb-8 text-lg leading-8 text-slate-500">
        <span class="font-semibold text-brand-600">Votre contribution est essentielle</span> pour construire des
        modèles d'IA qui reflètent la diversité et la richesse de notre continent. Chaque donnée partagée nous aide à
        réduire les biais et à développer des solutions véritablement adaptées à nos réalités africaines.
      </p>
      <div v-reveal="{ delay: 100 }" class="surface-muted p-6 text-left">
        <h3 class="mb-3 flex items-center gap-2 text-lg font-semibold text-brand-800">
          <LightbulbIcon class="h-5 w-5 text-brand-600" />
          Pourquoi c'est important ?
        </h3>
        <p class="leading-7 text-brand-700">
          Les données africaines sont sous-représentées dans les modèles d'IA internationaux. En partageant vos
          données, vous participez à la création d'une IA inclusive et représentative.
        </p>
      </div>
    </div>
  </section>

  <!-- Types de contribution -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-16 max-w-2xl text-center">
        <span class="section-eyebrow">Modalités</span>
        <h2 class="section-title">Comment contribuer ?</h2>
      </div>

      <div class="grid gap-8 md:grid-cols-3">
        <div v-for="(type, index) in contributionTypes" :key="type.id" v-reveal="{ delay: index * 100 }" class="surface-card-hover group p-6 text-center">
          <div class="icon-tile mx-auto mb-4 !h-16 !w-16">
            <component :is="type.icon" class="h-7 w-7" />
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">{{ type.title }}</h3>
          <p class="mb-4 text-sm text-slate-500">{{ type.description }}</p>
          <ul class="mb-5 space-y-1.5 text-left text-sm text-slate-500">
            <li v-for="item in type.items" :key="item" class="flex items-center gap-2">
              <span class="h-1 w-1 rounded-full bg-brand-400" />
              {{ item }}
            </li>
          </ul>
          <button type="button" class="btn-primary w-full" @click="selectForm(type.id)">
            Contribuer
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Formulaire dynamique -->
  <Transition
    enter-active-class="transition-all duration-300 ease-smooth"
    enter-from-class="opacity-0 -translate-y-4"
  >
    <section v-if="activeForm" ref="formSection" class="bg-white py-20">
      <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="surface-card p-8">
          <div class="mb-6 flex items-center justify-between">
            <h3 class="flex items-center gap-2.5 text-xl font-bold text-slate-900">
              <component :is="currentTypeMeta.icon" class="h-5.5 w-5.5 text-brand-600" />
              {{ currentTypeMeta.formTitle }}
            </h3>
            <button type="button" class="btn-icon h-9 w-9" aria-label="Fermer" @click="resetForm">
              <XIcon class="h-4.5 w-4.5" />
            </button>
          </div>

          <!-- Images -->
          <form v-if="activeForm === 'image'" class="space-y-6" @submit.prevent="submitForm">
            <div>
              <label class="field-label">Titre de la contribution *</label>
              <input v-model="form.titre" type="text" required class="field-input" placeholder="ex : Portrait femme Bamiléké" />
              <p v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</p>
            </div>

            <div>
              <label class="field-label">Nature de l'image *</label>
              <select v-model="form.nature" required class="field-input">
                <option value="">Sélectionnez la nature</option>
                <option value="portrait">Portrait personne africaine</option>
                <option value="medical">Image médicale</option>
                <option value="agriculture">Agriculture</option>
                <option value="elevage">Élevage</option>
                <option value="culture">Scène culturelle</option>
                <option value="urbain">Environnement urbain</option>
                <option value="nature">Nature / paysage</option>
              </select>
              <p v-if="form.errors.nature" class="field-error">{{ form.errors.nature }}</p>
            </div>

            <div>
              <label class="field-label">Description *</label>
              <textarea v-model="form.description" rows="3" required class="field-input" placeholder="Décrivez l'image, le contexte, la région…" />
              <p v-if="form.errors.description" class="field-error">{{ form.errors.description }}</p>
            </div>

            <div>
              <label class="field-label">Télécharger des images *</label>
              <div class="rounded-2xl border-2 border-dashed border-brand-200 p-6 text-center transition-colors hover:border-brand-400">
                <input id="image-upload" ref="imageInput" type="file" multiple accept="image/*" class="hidden" @change="handleImageUpload" />
                <label for="image-upload" class="cursor-pointer">
                  <UploadCloudIcon class="mx-auto h-9 w-9 text-brand-300" />
                  <p class="mt-2 text-sm text-slate-500">Glissez-déposez vos images ou</p>
                  <span class="btn-secondary btn-sm mt-3 inline-flex">Parcourir</span>
                </label>
                <div v-if="form.images.length > 0" class="mt-4 text-left">
                  <p class="text-sm font-medium text-brand-600">{{ form.images.length }} image(s) sélectionnée(s)</p>
                  <ul class="mt-1 space-y-0.5 text-xs text-slate-400">
                    <li v-for="(image, index) in form.images" :key="index">{{ image.name }}</li>
                  </ul>
                </div>
                <p class="field-hint mt-3">Formats : JPG, PNG, GIF • Max 10 Mo par image</p>
              </div>
              <p v-if="form.errors.images" class="field-error">{{ form.errors.images }}</p>
            </div>

            <div class="flex gap-3">
              <button type="button" class="btn-secondary flex-1" @click="resetForm">Annuler</button>
              <button type="submit" :disabled="form.processing" class="btn-primary flex-1">
                <SendIcon class="h-4.5 w-4.5" />
                {{ form.processing ? 'Envoi en cours…' : 'Envoyer les images' }}
              </button>
            </div>
          </form>

          <!-- Textes -->
          <form v-if="activeForm === 'texte'" class="space-y-6" @submit.prevent="submitForm">
            <div>
              <label class="field-label">Titre du texte *</label>
              <input v-model="form.titre" type="text" required class="field-input" placeholder="ex : Conte traditionnel Bassa" />
              <p v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</p>
            </div>

            <div>
              <label class="field-label">Thématique *</label>
              <select v-model="form.thematique" required class="field-input">
                <option value="">Sélectionnez la thématique</option>
                <option value="contes">Contes et légendes</option>
                <option value="traditions">Traditions culturelles</option>
                <option value="histoire">Histoire locale</option>
                <option value="savoir">Savoirs traditionnels</option>
                <option value="quotidien">Vie quotidienne</option>
                <option value="autre">Autre</option>
              </select>
              <p v-if="form.errors.thematique" class="field-error">{{ form.errors.thematique }}</p>
            </div>

            <div>
              <label class="field-label">Langue *</label>
              <select v-model="form.langue" required class="field-input">
                <option value="">Sélectionnez la langue</option>
                <option value="français">Français</option>
                <option value="anglais">Anglais</option>
                <option value="ewondo">Ewondo</option>
                <option value="dual">Duala</option>
                <option value="bassa">Bassa</option>
                <option value="autre">Autre langue locale</option>
              </select>
              <p v-if="form.errors.langue" class="field-error">{{ form.errors.langue }}</p>
            </div>

            <div>
              <label class="field-label">Votre texte *</label>
              <textarea v-model="form.contenu_texte" rows="6" required class="field-input" placeholder="Racontez votre histoire, tradition ou savoir…" />
              <p class="field-hint">{{ form.contenu_texte ? form.contenu_texte.length : 0 }} caractères</p>
              <p v-if="form.errors.contenu_texte" class="field-error">{{ form.errors.contenu_texte }}</p>
            </div>

            <div class="surface-muted p-4">
              <h4 class="mb-2 flex items-center gap-2 font-semibold text-brand-800">
                <LightbulbIcon class="h-4.5 w-4.5" />
                Exemples de contributions
              </h4>
              <ul class="space-y-1 text-sm text-brand-700">
                <li>• Récit sur la dot et le mariage traditionnel</li>
                <li>• Description des funérailles et rites</li>
                <li>• Jeux culturels et traditionnels</li>
                <li>• Organisation des chefferies</li>
                <li>• Recettes de médecine traditionnelle</li>
              </ul>
            </div>

            <div class="flex gap-3">
              <button type="button" class="btn-secondary flex-1" @click="resetForm">Annuler</button>
              <button type="submit" :disabled="form.processing" class="btn-primary flex-1">
                <SendIcon class="h-4.5 w-4.5" />
                {{ form.processing ? 'Envoi en cours…' : 'Envoyer le texte' }}
              </button>
            </div>
          </form>

          <!-- Datasets -->
          <form v-if="activeForm === 'dataset'" class="space-y-6" @submit.prevent="submitForm">
            <div>
              <label class="field-label">Nom du dataset *</label>
              <input v-model="form.titre" type="text" required class="field-input" placeholder="ex : donnees_agriculture_cameroun" />
              <p v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</p>
            </div>

            <div>
              <label class="field-label">Domaine concerné *</label>
              <select v-model="form.domaine" required class="field-input">
                <option value="">Sélectionnez le domaine</option>
                <option value="sante">Santé</option>
                <option value="agriculture">Agriculture</option>
                <option value="elevage">Élevage</option>
                <option value="environnement">Environnement</option>
                <option value="education">Éducation</option>
                <option value="economie">Économie</option>
                <option value="transport">Transport</option>
                <option value="autre">Autre</option>
              </select>
              <p v-if="form.errors.domaine" class="field-error">{{ form.errors.domaine }}</p>
            </div>

            <div>
              <label class="field-label">Description des données *</label>
              <textarea v-model="form.description" rows="4" required class="field-input" placeholder="Décrivez les variables, la méthodologie de collecte, la période…" />
              <p v-if="form.errors.description" class="field-error">{{ form.errors.description }}</p>
            </div>

            <div>
              <label class="field-label">Télécharger le dataset *</label>
              <div class="rounded-2xl border-2 border-dashed border-brand-200 p-6 text-center transition-colors hover:border-brand-400">
                <input id="dataset-upload" ref="datasetInput" type="file" accept=".csv,.txt,.xlsx,.xls,.json" class="hidden" @change="handleDatasetUpload" />
                <label for="dataset-upload" class="cursor-pointer">
                  <DatabaseIcon class="mx-auto h-9 w-9 text-brand-300" />
                  <p class="mt-2 text-sm text-slate-500">Glissez-déposez votre fichier ou</p>
                  <span class="btn-secondary btn-sm mt-3 inline-flex">Parcourir</span>
                </label>
                <div v-if="form.fichier_dataset" class="mt-4">
                  <p class="text-sm font-medium text-brand-600">Fichier sélectionné : {{ form.fichier_dataset.name }}</p>
                  <p class="text-xs text-slate-400">Taille : {{ (form.fichier_dataset.size / 1024 / 1024).toFixed(2) }} Mo</p>
                </div>
                <p class="field-hint mt-3">Formats acceptés : CSV, TXT, Excel, JSON • Max 50 Mo</p>
              </div>
              <p v-if="form.errors.fichier_dataset" class="field-error">{{ form.errors.fichier_dataset }}</p>
            </div>

            <div class="surface-muted p-4">
              <h4 class="mb-2 flex items-center gap-2 font-semibold text-brand-800">
                <GlobeIcon class="h-4.5 w-4.5" />
                Préférence africaine
              </h4>
              <p class="text-sm leading-6 text-brand-700">
                Nous privilégions les données issues du contexte africain pour une IA véritablement représentative de
                notre écosystème.
              </p>
            </div>

            <div class="flex gap-3">
              <button type="button" class="btn-secondary flex-1" @click="resetForm">Annuler</button>
              <button type="submit" :disabled="form.processing" class="btn-primary flex-1">
                <SendIcon class="h-4.5 w-4.5" />
                {{ form.processing ? 'Envoi en cours…' : 'Envoyer le dataset' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </Transition>

  <!-- Confidentialité et éthique -->
  <section class="bg-brand-50/50 py-20">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
      <div v-reveal class="mx-auto mb-12 max-w-2xl text-center">
        <span class="section-eyebrow">
          <ShieldCheckIcon class="h-3.5 w-3.5" />
          Éthique
        </span>
        <h2 class="section-title">Confidentialité &amp; éthique</h2>
      </div>

      <div class="grid gap-8 md:grid-cols-2">
        <div v-reveal class="surface-card p-6">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-gradient">
            <CheckIcon class="h-5.5 w-5.5 text-white" />
          </div>
          <h3 class="mb-3 text-lg font-semibold text-slate-900">Consentement explicite</h3>
          <p class="leading-7 text-slate-500">Toutes les contributions sont soumises à un consentement éclairé et peuvent être retirées à tout moment.</p>
        </div>

        <div v-reveal="{ delay: 100 }" class="surface-card p-6">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-gradient">
            <LockIcon class="h-5.5 w-5.5 text-white" />
          </div>
          <h3 class="mb-3 text-lg font-semibold text-slate-900">Sécurité des données</h3>
          <p class="leading-7 text-slate-500">Chiffrement de bout en bout et stockage sécurisé conforme aux réglementations RGPD et locales.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import { useForm } from '@inertiajs/vue3'
import {
  CheckIcon,
  DatabaseIcon,
  GlobeIcon,
  ImageIcon,
  LightbulbIcon,
  LockIcon,
  SendIcon,
  ShieldCheckIcon,
  TypeIcon,
  UploadCloudIcon,
  XIcon,
} from 'lucide-vue-next'
import PageHero from '@/Components/PageHero.vue'

const formSection = ref(null)
const imageInput = ref(null)
const datasetInput = ref(null)
const activeForm = ref(null)

// Un seul useForm() couvrant les 3 types : Inertia gère nativement le CSRF,
// l'envoi multipart (dès qu'un File est présent) et le peuplement de
// form.errors.* en cas de 422 — plus besoin de fetch/axios manuel.
const form = useForm({
  type: '',
  titre: '',
  nature: '',
  description: '',
  images: [],
  thematique: '',
  langue: '',
  contenu_texte: '',
  domaine: '',
  fichier_dataset: null,
})

const contributionTypes = [
  {
    id: 'image',
    icon: ImageIcon,
    formTitle: 'Contribuer avec des images',
    title: 'Images',
    description: 'Photos représentant la diversité africaine',
    items: ['Personnes africaines', 'Scènes de vie quotidienne', 'Images médicales', 'Agriculture et élevage'],
  },
  {
    id: 'texte',
    icon: TypeIcon,
    formTitle: 'Contribuer avec du texte',
    title: 'Textes',
    description: 'Récits et textes en langues africaines',
    items: ['Contes et histoires', 'Traditions culturelles', 'Textes en langues locales', 'Savoirs traditionnels'],
  },
  {
    id: 'dataset',
    icon: DatabaseIcon,
    formTitle: 'Contribuer avec un dataset',
    title: 'Jeux de données',
    description: 'Données structurées et datasets complets',
    items: ['Données environnementales', 'Données économiques', 'Données sanitaires', 'Données agricoles'],
  },
]

const currentTypeMeta = computed(() => contributionTypes.find((t) => t.id === activeForm.value) || contributionTypes[0])

async function selectForm(typeId) {
  form.clearErrors()
  activeForm.value = typeId
  form.type = typeId
  await nextTick()
  formSection.value?.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

const handleImageUpload = (event) => {
  const files = event.target.files
  if (files && files.length > 0) {
    form.images = Array.from(files)
  }
}

const handleDatasetUpload = (event) => {
  const file = event.target.files?.[0]
  if (file) {
    form.fichier_dataset = file
  }
}

const resetForm = () => {
  form.reset()
  form.clearErrors()
  activeForm.value = null

  if (imageInput.value) imageInput.value.value = ''
  if (datasetInput.value) datasetInput.value.value = ''
}

const submitForm = () => {
  form.post('/contributions', {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => resetForm(),
  })
}
</script>
