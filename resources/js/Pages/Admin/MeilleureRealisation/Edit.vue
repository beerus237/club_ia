<!-- resources/js/Pages/Admin/MeilleureRealisation/Edit.vue -->
<template>
  <AdminLayout
    title="Meilleure Réalisation"
    description="Configurez la réalisation mise en avant sur la page d'accueil"
  >
    <div class="mx-auto max-w-4xl">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">
          Meilleure Réalisation du Semestre
        </h1>
        <Link href="/admin/dashboard" class="flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
          <ArrowLeftIcon class="h-4 w-4" />
          Retour au tableau de bord
        </Link>
      </div>

      <!-- Aperçu en temps réel -->
      <div class="mb-6 rounded-2xl bg-brand-gradient p-6 text-white">
        <h3 class="mb-3 flex items-center gap-2 font-semibold">
          <SparklesIcon class="h-4.5 w-4.5" />
          Aperçu sur le site
        </h3>
        <div class="rounded-xl bg-white/10 p-4">
          <div class="flex items-center gap-4">
            <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-xl bg-white/20">
              <TrophyIcon v-if="!form.image_url" class="h-10 w-10 text-white/80" />
              <img v-else :src="form.image_url" alt="Preview" class="h-full w-full rounded-lg object-cover">
            </div>
            <div>
              <span class="badge bg-white/20 text-white">{{ form.categorie || 'Catégorie' }}</span>
              <h4 class="mt-2 text-xl font-bold">{{ form.titre || 'Titre de la réalisation' }}</h4>
              <p class="mt-1 text-sm text-white/80">{{ form.description || 'Description de la réalisation...' }}</p>
            </div>
          </div>
        </div>
      </div>

      <form @submit.prevent="submit" class="surface-card p-6 space-y-6">
        <!-- Titre -->
        <div>
          <label class="field-label">Titre *</label>
          <input v-model="form.titre" type="text" required
                 class="field-input"
                 placeholder="Titre impressionnant de la réalisation">
          <div v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</div>
        </div>

        <!-- Catégorie -->
        <div>
          <label class="field-label">Catégorie *</label>
          <select v-model="form.categorie" required
                  class="field-input">
            <option value="">Sélectionnez une catégorie</option>
            <option value="Santé & Innovation">Santé & Innovation</option>
            <option value="Agriculture Intelligente">Agriculture Intelligente</option>
            <option value="Éducation & Formation">Éducation & Formation</option>
            <option value="Recherche Avancée">Recherche Avancée</option>
            <option value="Développement Durable">Développement Durable</option>
            <option value="Technologie Emergente">Technologie Emergente</option>
          </select>
          <div v-if="form.errors.categorie" class="field-error">{{ form.errors.categorie }}</div>
        </div>

        <!-- Description -->
        <div>
          <label class="field-label">Description *</label>
          <textarea v-model="form.description" rows="4" required
                    class="field-input"
                    placeholder="Description détaillée des résultats et impacts de la réalisation..."></textarea>
          <div v-if="form.errors.description" class="field-error">{{ form.errors.description }}</div>
        </div>

        <!-- Image -->
        <ImageUploader
          label="Image"
          :model-url="form.image_url"
          @update:file="(file) => (form.image = file)"
          @update:url="(url) => (form.image_url = url)"
        />
        <div v-if="form.errors.image || form.errors.image_url" class="field-error">{{ form.errors.image || form.errors.image_url }}</div>

        <!-- Lien vers le projet -->
        <div>
          <label class="field-label">Lien vers le projet</label>
          <input v-model="form.lien" type="url"
                 class="field-input"
                 placeholder="https://exemple.com/projet">
          <div class="field-hint">Lien vers la page détaillée du projet</div>
        </div>

        <!-- Informations importantes -->
        <div class="rounded-2xl border border-brand-200 bg-brand-50 p-4">
          <div class="flex items-start gap-3">
            <LightbulbIcon class="mt-0.5 h-5 w-5 shrink-0 text-brand-600" />
            <div>
              <h4 class="font-semibold text-brand-900">Important</h4>
              <p class="mt-1 text-sm text-brand-700">
                Cette réalisation sera affichée en évidence sur la page d'accueil.
                Pensez à mettre à jour cette section chaque semestre pour garder le contenu frais et engageant.
              </p>
            </div>
          </div>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
          <Link href="/admin/dashboard" class="btn-secondary">
            Annuler
          </Link>
          <button type="submit" :disabled="form.processing"
                  class="btn-primary">
            {{ form.processing ? 'Mise à jour...' : 'Mettre à jour' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ArrowLeftIcon, LightbulbIcon, SparklesIcon, TrophyIcon } from 'lucide-vue-next'
import ImageUploader from '@/Components/Admin/ImageUploader.vue'

const props = defineProps({
  realisation: Object
})

const form = useForm({
  id: props.realisation?.id || null,
  titre: props.realisation?.titre || '',
  categorie: props.realisation?.categorie || '',
  description: props.realisation?.description || '',
  image: null,
  image_url: props.realisation?.image_url || '',
  lien: props.realisation?.lien || ''
})

const submit = () => {
  form.transform((data) => ({ ...data, _method: 'put' })).post('/admin/meilleure-realisation', {
    forceFormData: true,
  })
}
</script>
