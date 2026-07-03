<!-- resources/js/Pages/Admin/Carousel/Components/CarouselForm.vue -->
<template>
  <div class="mx-auto max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-xl font-bold text-slate-900">{{ isEdit ? 'Modifier le slide' : 'Créer un slide' }}</h1>
      <Link href="/admin/carousel" class="flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
        <ArrowLeftIcon class="h-4 w-4" />
        Retour à la liste
      </Link>
    </div>

    <form class="surface-card space-y-6 p-6" @submit.prevent="submit">
      <!-- Aperçu en temps réel -->
      <div class="rounded-2xl border-2 border-dashed border-brand-200 bg-brand-50/40 p-4">
        <h3 class="mb-3 text-sm font-bold text-slate-600">Aperçu du slide</h3>
        <div class="relative h-40 overflow-hidden rounded-xl">
          <div
            class="flex h-full w-full items-center justify-center bg-cover bg-center"
            :style="previewImage ? { backgroundImage: `url(${previewImage})` } : { background: 'linear-gradient(135deg, #36b3f5, #0079c4)' }"
          >
            <div class="rounded-xl bg-slate-900/40 p-4 text-center text-white backdrop-blur-sm">
              <h4 class="text-lg font-bold">{{ form.titre || 'Titre du slide' }}</h4>
              <p class="text-sm">{{ form.description || 'Description du slide' }}</p>
            </div>
          </div>
        </div>
      </div>

      <div>
        <label class="field-label">Titre *</label>
        <input v-model="form.titre" type="text" required maxlength="100" class="field-input" placeholder="Titre accrocheur pour le slide" />
        <p class="field-hint">{{ form.titre.length }}/100 caractères</p>
        <p v-if="form.errors.titre" class="field-error">{{ form.errors.titre }}</p>
      </div>

      <div>
        <label class="field-label">Description *</label>
        <textarea v-model="form.description" rows="3" required maxlength="200" class="field-input" placeholder="Description concise et engageante" />
        <p class="field-hint">{{ form.description.length }}/200 caractères</p>
        <p v-if="form.errors.description" class="field-error">{{ form.errors.description }}</p>
      </div>

      <ImageUploader
        label="Image du slide *"
        :model-url="form.image_url"
        @update:file="(file) => (form.image = file)"
        @update:url="(url) => (form.image_url = url)"
        @update:preview="(url) => (previewImage = url)"
      />
      <p class="field-hint -mt-3">Format paysage recommandé (16:9).</p>
      <p v-if="form.errors.image || form.errors.image_url" class="field-error">{{ form.errors.image || form.errors.image_url }}</p>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
          <label class="field-label">Ordre d'affichage</label>
          <input v-model="form.ordre" type="number" min="0" max="10" class="field-input" />
          <p class="field-hint">Les slides sont triés par ordre croissant</p>
        </div>

        <label class="flex cursor-pointer items-center gap-3 self-end rounded-xl border border-brand-100 bg-brand-50/50 px-4 py-3">
          <input v-model="form.est_actif" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-400" />
          <span class="text-sm font-medium text-slate-700">Slide actif (visible sur le site)</span>
        </label>
      </div>

      <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
        <Link href="/admin/carousel" class="btn-secondary">Annuler</Link>
        <button type="submit" class="btn-primary" :disabled="form.processing">
          {{ form.processing ? (isEdit ? 'Mise à jour…' : 'Création…') : isEdit ? 'Modifier' : 'Créer' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { ArrowLeftIcon } from 'lucide-vue-next'
import ImageUploader from '@/Components/Admin/ImageUploader.vue'

const props = defineProps({
  slide: Object,
  isEdit: Boolean,
})

const form = useForm({
  titre: props.slide?.titre || '',
  description: props.slide?.description || '',
  image: null,
  image_url: props.slide?.image_url || '',
  ordre: props.slide?.ordre || 0,
  est_actif: props.slide?.est_actif ?? true,
})

// Mirrors whatever the uploader is currently showing (uploaded file blob or URL)
const previewImage = ref(props.slide?.image_url || '')

const submit = () => {
  if (props.isEdit) {
    form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/carousel/${props.slide.id}`, {
      forceFormData: true,
    })
  } else {
    form.post('/admin/carousel', { forceFormData: true })
  }
}
</script>
