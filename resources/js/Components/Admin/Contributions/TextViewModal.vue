<template>
  <Teleport to="body">
    <div class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm" @click.self="$emit('close')">
      <div class="flex max-h-[85vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-card-hover">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
          <div class="flex items-center gap-2.5">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
              <FileTextIcon class="h-4.5 w-4.5" />
            </div>
            <h3 class="text-base font-bold text-slate-900">Contenu texte</h3>
          </div>
          <button type="button" class="btn-icon" aria-label="Fermer" @click="$emit('close')">
            <XIcon class="h-4.5 w-4.5" />
          </button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-5">
          <div class="surface-muted p-4">
            <h4 class="font-bold text-slate-900">{{ contribution.titre }}</h4>
            <p class="mt-2 whitespace-pre-wrap text-sm leading-7 text-slate-600">{{ contribution.contenu_texte }}</p>
          </div>

          <div class="mt-4 grid grid-cols-1 gap-3 text-sm text-slate-500 sm:grid-cols-2">
            <div v-if="contribution.thematique"><span class="font-semibold text-slate-700">Thématique :</span> {{ contribution.thematique }}</div>
            <div v-if="contribution.langue"><span class="font-semibold text-slate-700">Langue :</span> {{ contribution.langue }}</div>
            <div v-if="contribution.nature"><span class="font-semibold text-slate-700">Nature :</span> {{ contribution.nature }}</div>
          </div>
        </div>

        <div class="flex flex-wrap justify-end gap-2.5 border-t border-slate-100 bg-slate-50/60 px-6 py-4">
          <button type="button" class="btn-secondary btn-sm" @click="copyText">
            <CopyIcon class="h-4 w-4" />
            Copier
          </button>
          <button type="button" class="btn-primary btn-sm" @click="exportToWord">
            <DownloadIcon class="h-4 w-4" />
            Exporter Word
          </button>
          <button type="button" class="btn-ghost btn-sm" @click="$emit('close')">
            Fermer
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { CopyIcon, DownloadIcon, FileTextIcon, XIcon } from 'lucide-vue-next'

const props = defineProps({
  contribution: {
    type: Object,
    required: true,
  },
})

defineEmits(['close'])

function copyText() {
  navigator.clipboard
    .writeText(props.contribution.contenu_texte)
    .catch((err) => console.error('Erreur lors de la copie:', err))
}

function exportToWord() {
  const content = `
    <html>
      <head><meta charset="UTF-8"><title>${props.contribution.titre}</title></head>
      <body>
        <h1>${props.contribution.titre}</h1>
        <p>${props.contribution.contenu_texte}</p>
      </body>
    </html>
  `

  const blob = new Blob([content], { type: 'application/msword' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = `${props.contribution.titre}.doc`
  link.click()
  URL.revokeObjectURL(link.href)
}
</script>
