<template>
  <div>
    <label class="field-label">{{ label }}</label>

    <!-- Preview -->
    <div
      class="group relative flex h-48 w-full items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed transition-colors duration-300"
      :class="isDragging ? 'border-brand-400 bg-brand-50' : 'border-brand-200 bg-brand-50/40'"
      @dragover.prevent="isDragging = true"
      @dragleave.prevent="isDragging = false"
      @drop.prevent="handleDrop"
    >
      <template v-if="previewUrl">
        <img :src="previewUrl" alt="Aperçu de l'image" class="h-full w-full object-cover" />
        <button
          type="button"
          class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-lg bg-slate-900/60 text-white opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100"
          aria-label="Retirer l'image"
          @click="clearImage"
        >
          <XIcon class="h-4 w-4" />
        </button>
        <label class="absolute inset-x-0 bottom-0 cursor-pointer bg-slate-900/60 py-2 text-center text-xs font-semibold text-white opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100">
          Changer l'image
          <input type="file" accept="image/*" class="hidden" @change="handleFileInput" />
        </label>
      </template>

      <label v-else class="flex h-full w-full cursor-pointer flex-col items-center justify-center gap-2 text-center">
        <UploadCloudIcon class="h-9 w-9 text-brand-300" />
        <span class="text-sm font-medium text-slate-600">Glissez-déposez une image ou <span class="text-brand-600 underline">parcourez</span></span>
        <span class="text-xs text-slate-400">PNG, JPG, WEBP • Max 5 Mo</span>
        <input type="file" accept="image/*" class="hidden" @change="handleFileInput" />
      </label>
    </div>

    <p v-if="error" class="field-error">{{ error }}</p>

    <!-- URL fallback -->
    <button type="button" class="mt-2 text-xs font-semibold text-brand-600 hover:text-brand-700" @click="showUrlInput = !showUrlInput">
      {{ showUrlInput ? 'Masquer le champ URL' : "Utiliser une image déjà en ligne (URL) à la place" }}
    </button>

    <div v-if="showUrlInput" class="mt-2">
      <input
        type="url"
        :value="urlValue"
        placeholder="https://exemple.com/image.jpg"
        class="field-input"
        @input="handleUrlInput"
      />
      <p class="field-hint">Renseigner une URL efface le fichier sélectionné ci-dessus (et inversement).</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { UploadCloudIcon, XIcon } from 'lucide-vue-next'

const props = defineProps({
  label: {
    type: String,
    default: "Image",
  },
  // Existing image URL (edit mode) shown as the initial preview
  modelUrl: {
    type: String,
    default: '',
  },
  maxSizeMb: {
    type: Number,
    default: 5,
  },
})

// v-model:file -> the raw File object to submit (null if unchanged / using URL)
// v-model:url -> the URL string to submit when no new file is chosen
const emit = defineEmits(['update:file', 'update:url', 'update:preview'])

const isDragging = ref(false)
const showUrlInput = ref(false)
const error = ref('')
const previewUrl = ref(props.modelUrl || '')

watch(previewUrl, (val) => emit('update:preview', val))
const urlValue = ref(props.modelUrl || '')

watch(
  () => props.modelUrl,
  (val) => {
    if (!previewUrl.value) {
      previewUrl.value = val || ''
      urlValue.value = val || ''
    }
  }
)

function validateAndEmit(file) {
  error.value = ''

  if (!file.type.startsWith('image/')) {
    error.value = 'Le fichier doit être une image.'
    return
  }

  if (file.size > props.maxSizeMb * 1024 * 1024) {
    error.value = `L'image dépasse la taille maximale de ${props.maxSizeMb} Mo.`
    return
  }

  previewUrl.value = URL.createObjectURL(file)
  showUrlInput.value = false
  urlValue.value = ''
  emit('update:file', file)
  emit('update:url', '')
}

function handleFileInput(event) {
  const file = event.target.files?.[0]
  if (file) validateAndEmit(file)
}

function handleDrop(event) {
  isDragging.value = false
  const file = event.dataTransfer?.files?.[0]
  if (file) validateAndEmit(file)
}

function handleUrlInput(event) {
  const value = event.target.value
  urlValue.value = value
  previewUrl.value = value
  emit('update:url', value)
  emit('update:file', null)
}

function clearImage() {
  previewUrl.value = ''
  urlValue.value = ''
  error.value = ''
  emit('update:file', null)
  emit('update:url', '')
}
</script>
