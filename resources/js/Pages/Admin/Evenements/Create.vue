<!-- resources/js/Pages/Admin/Evenements/Create.vue -->
<template>
  <AdminLayout
    title="Créer un événement"
    description="Ajoutez un nouvel événement"
  >
    <div class="mx-auto max-w-4xl">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">Créer un événement</h1>
        <Link href="/admin/evenements" class="flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
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
        </div>

        <!-- Description -->
        <div>
          <label class="field-label">Description *</label>
          <textarea v-model="form.description" rows="4" required
                    class="field-input"></textarea>
        </div>

        <!-- Date de début -->
        <div>
          <label class="field-label">Date de début *</label>
          <input v-model="form.date_debut" type="datetime-local" required
                 class="field-input">
        </div>

        <!-- Date de fin -->
        <div>
          <label class="field-label">Date de fin (optionnel)</label>
          <input v-model="form.date_fin" type="datetime-local"
                 class="field-input">
        </div>

        <!-- Lieu -->
        <div>
          <label class="field-label">Lieu *</label>
          <input v-model="form.lieu" type="text" required
                 class="field-input">
        </div>

        <ImageUploader
          label="Image (optionnel)"
          :model-url="form.image_url"
          @update:file="(file) => (form.image = file)"
          @update:url="(url) => (form.image_url = url)"
        />
        <div v-if="form.errors.image || form.errors.image_url" class="field-error">{{ form.errors.image || form.errors.image_url }}</div>

        <!-- Statut -->
        <div class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-brand-100 bg-brand-50/50 px-4 py-3">
          <input v-model="form.est_actif" type="checkbox"
                 class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-400">
          <label class="text-sm font-medium text-slate-700">Événement actif</label>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
          <Link href="/admin/evenements" class="btn-secondary">
            Annuler
          </Link>
          <button type="submit" :disabled="form.processing"
                  class="btn-primary">
            {{ form.processing ? 'Création...' : 'Créer l\'événement' }}
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
  description: '',
  date_debut: '',
  date_fin: '',
  lieu: '',
  image: null,
  image_url: '',
  est_actif: true
})

const submit = () => {
  form.post('/admin/evenements', { forceFormData: true })
}
</script>
