<!-- resources/js/Pages/Admin/Projets/Edit.vue -->
<template>
  <AdminLayout
    title="Modifier le projet"
    description="Modifiez les détails du projet"
  >
    <div class="mx-auto max-w-4xl">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">
          Modifier le projet
        </h1>
        <Link href="/admin/projets" class="flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
          <ArrowLeftIcon class="h-4 w-4" />
          Retour à la liste
        </Link>
      </div>

      <form @submit.prevent="submit" class="surface-card p-6 space-y-6">
        <!-- Titre -->
        <div>
          <label class="field-label">Titre *</label>
          <input v-model="form.titre" type="text" required
                 class="field-input">
          <div v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</div>
        </div>

        <!-- Description -->
        <div>
          <label class="field-label">Description *</label>
          <textarea v-model="form.description" rows="4" required
                    class="field-input"></textarea>
          <div v-if="form.errors.description" class="field-error">{{ form.errors.description }}</div>
        </div>

        <!-- Catégorie -->
        <div>
          <label class="field-label">Catégorie *</label>
          <input v-model="form.categorie" list="categories-list" required class="field-input" placeholder="ex : Santé, NLP, Robotique…" />
          <datalist id="categories-list">
            <option v-for="category in categories" :key="category" :value="category" />
          </datalist>
          <p class="field-hint">Choisissez une catégorie existante ou tapez-en une nouvelle.</p>
          <div v-if="form.errors.categorie" class="field-error">{{ form.errors.categorie }}</div>
        </div>

        <!-- Statut -->
        <div>
          <label class="field-label">Statut *</label>
          <select v-model="form.statut" required
                  class="field-input">
            <option value="">Sélectionnez un statut</option>
            <option v-for="statut in statuts" :key="statut" :value="statut">
              {{ statut }}
            </option>
          </select>
          <div v-if="form.errors.statut" class="field-error">{{ form.errors.statut }}</div>
        </div>

        <!-- Équipe -->
        <div>
          <label class="field-label">Équipe (optionnel)</label>
          <input v-model="form.equipe" type="text"
                 class="field-input">
          <div v-if="form.errors.equipe" class="field-error">{{ form.errors.equipe }}</div>
        </div>

        <!-- Liens -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Lien démo (optionnel)</label>
            <input v-model="form.lien_demo" type="url" placeholder="https://exemple.com/demo"
                   class="field-input">
          </div>
          <div>
            <label class="field-label">Lien GitHub (optionnel)</label>
            <input v-model="form.lien_github" type="url" placeholder="https://github.com/user/repo"
                   class="field-input">
          </div>
        </div>

        <!-- Image -->
        <ImageUploader
          label="Image (optionnel)"
          :model-url="form.image_url"
          @update:file="(file) => (form.image = file)"
          @update:url="(url) => (form.image_url = url)"
        />
        <div v-if="form.errors.image || form.errors.image_url" class="field-error">{{ form.errors.image || form.errors.image_url }}</div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Date de début (optionnel)</label>
            <input v-model="form.date_debut" type="date"
                   class="field-input">
          </div>
          <div>
            <label class="field-label">Date de fin (optionnel)</label>
            <input v-model="form.date_fin" type="date"
                   class="field-input">
          </div>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
          <Link href="/admin/projets" class="btn-secondary">
            Annuler
          </Link>
          <button type="submit" :disabled="form.processing"
                  class="btn-primary">
            {{ form.processing ? 'Mise à jour...' : 'Modifier' }}
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
import { ArrowLeftIcon } from 'lucide-vue-next'
import ImageUploader from '@/Components/Admin/ImageUploader.vue'

const props = defineProps({
  categories: Array,
  statuts: Array,
  projet: Object
})

const form = useForm({
  titre: props.projet.titre,
  description: props.projet.description,
  categorie: props.projet.categorie,
  statut: props.projet.statut,
  equipe: props.projet.equipe || '',
  lien_demo: props.projet.lien_demo || '',
  lien_github: props.projet.lien_github || '',
  image: null,
  image_url: props.projet.image_url || '',
  date_debut: props.projet.date_debut || '',
  date_fin: props.projet.date_fin || ''
})

const submit = () => {
  form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/projets/${props.projet.id}`, {
    forceFormData: true,
  })
}
</script>
