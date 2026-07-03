<!-- resources/js/Pages/Admin/Actualites/Create.vue -->
<template>
  <AdminLayout
    title="Créer une actualité"
    description="Ajoutez une nouvelle actualité"
  >
    <div class="mx-auto max-w-4xl">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">Créer une actualité</h1>
        <Link href="/admin/actualites" class="flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
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

        <!-- Contenu -->
        <div>
          <label class="field-label">Contenu *</label>
          <textarea v-model="form.contenu" rows="6" required
                    class="field-input"></textarea>
          <div v-if="form.errors.contenu" class="field-error">{{ form.errors.contenu }}</div>
        </div>

        <!-- Catégorie -->
        <div>
          <label class="field-label">Catégorie *</label>
          <select v-model="form.categorie" required
                  class="field-input">
            <option value="">Sélectionnez une catégorie</option>
            <option value="Santé">Santé</option>
            <option value="Agriculture">Agriculture</option>
            <option value="Éducation">Éducation</option>
            <option value="Technologie">Technologie</option>
            <option value="Économie">Économie</option>
            <option value="Environnement">Environnement</option>
            <option value="Autre">Autre</option>
          </select>
          <div v-if="form.errors.categorie" class="field-error">{{ form.errors.categorie }}</div>
        </div>

        <!-- Lien externe personnalisé -->
        <div>
          <label class="field-label">Lien "Lire plus" (optionnel)</label>
          <input v-model="form.lien_externe" type="url" placeholder="https://exemple.com/article"
                 class="field-input">
          <p class="field-hint">Lien personnalisé pour le bouton "Lire plus". Laissez vide si l'actualité est complète ici.</p>
          <div v-if="form.errors.lien_externe" class="field-error">{{ form.errors.lien_externe }}</div>
        </div>

        <!-- Image -->
        <ImageUploader
          label="Image (optionnel)"
          :model-url="form.image_url"
          @update:file="(file) => (form.image = file)"
          @update:url="(url) => (form.image_url = url)"
        />
        <div v-if="form.errors.image || form.errors.image_url" class="field-error">{{ form.errors.image || form.errors.image_url }}</div>

        <!-- Date de publication -->
        <div>
          <label class="field-label">Date de publication *</label>
          <input v-model="form.date_publication" type="date" required
                 class="field-input">
          <div v-if="form.errors.date_publication" class="field-error">{{ form.errors.date_publication }}</div>
        </div>

        <!-- Auteur -->
        <div>
          <label class="field-label">Auteur (optionnel)</label>
          <input v-model="form.auteur" type="text"
                 class="field-input">
          <div v-if="form.errors.auteur" class="field-error">{{ form.errors.auteur }}</div>
        </div>

        <!-- Statut -->
        <div class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-brand-100 bg-brand-50/50 px-4 py-3">
          <input v-model="form.est_publie" type="checkbox"
                 class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-400">
          <label class="text-sm font-medium text-slate-700">Publier immédiatement</label>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
          <Link href="/admin/actualites" class="btn-secondary">
            Annuler
          </Link>
          <button type="submit" :disabled="form.processing"
                  class="btn-primary">
            {{ form.processing ? 'Création...' : 'Créer l\'actualité' }}
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

const form = useForm({
  titre: '',
  contenu: '',
  categorie: '',
  image: null,
  image_url: '',
  lien_externe: '', // Lien personnalisé
  date_publication: new Date().toISOString().split('T')[0],
  auteur: '',
  est_publie: false
})

const submit = () => {
  form.post('/admin/actualites', { forceFormData: true })
}
</script>
