<!-- resources/js/Pages/Admin/Contributions/Show.vue -->
<template>
  <AdminLayout :title="contribution.titre" :description="`Détails de la contribution — ${typeLabels[contribution.type]}`">
    <div class="mx-auto max-w-6xl space-y-6">
      <!-- Header -->
      <div class="surface-card flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <Link href="/admin/contributions" class="mb-2 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
            <ArrowLeftIcon class="h-4 w-4" />
            Retour à la liste
          </Link>
          <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">{{ contribution.titre }}</h1>
          <p class="mt-1 text-sm text-slate-500">Soumis le {{ formatDate(contribution.created_at) }}</p>
        </div>
        <span class="badge text-sm" :class="statusColors[contribution.statut]">
          {{ statusLabels[contribution.statut] }}
        </span>
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Sidebar -->
        <div class="space-y-6 lg:col-span-1">
          <div class="surface-card p-6">
            <h2 class="mb-4 flex items-center gap-2 text-base font-bold text-slate-900">
              <InfoIcon class="h-5 w-5 text-brand-500" />
              Informations générales
            </h2>
            <dl class="space-y-3 text-sm">
              <div class="flex items-center justify-between">
                <dt class="font-medium text-slate-500">Type</dt>
                <dd><span class="badge" :class="typeColors[contribution.type]">{{ typeLabels[contribution.type] }}</span></dd>
              </div>
              <div class="flex items-center justify-between">
                <dt class="font-medium text-slate-500">Soumis par</dt>
                <dd class="font-medium text-slate-800">{{ contribution.user?.name || 'Anonyme' }}</dd>
              </div>
              <div class="flex items-center justify-between">
                <dt class="font-medium text-slate-500">Date</dt>
                <dd class="font-medium text-slate-800">{{ formatDate(contribution.created_at) }}</dd>
              </div>
              <div class="flex items-center justify-between">
                <dt class="font-medium text-slate-500">Statut</dt>
                <dd><span class="badge" :class="statusColors[contribution.statut]">{{ statusLabels[contribution.statut] }}</span></dd>
              </div>
            </dl>
          </div>

          <div class="surface-card p-6">
            <h2 class="mb-4 flex items-center gap-2 text-base font-bold text-slate-900">
              <SettingsIcon class="h-5 w-5 text-brand-500" />
              Actions
            </h2>
            <div class="space-y-2.5">
              <button v-if="contribution.statut === 'en_attente'" type="button" class="btn-primary w-full !bg-emerald-600 hover:!bg-emerald-700" @click="openConfirmation('approve', contribution)">
                <CheckIcon class="h-4.5 w-4.5" />
                Approuver
              </button>

              <button v-if="contribution.statut === 'en_attente'" type="button" class="btn-danger w-full" @click="openConfirmation('reject', contribution)">
                <XIcon class="h-4.5 w-4.5" />
                Rejeter
              </button>

              <button v-if="['image', 'dataset'].includes(contribution.type)" type="button" class="btn-secondary w-full" @click="downloadFile(contribution)">
                <DownloadIcon class="h-4.5 w-4.5" />
                Télécharger
              </button>

              <template v-if="contribution.type === 'texte'">
                <button type="button" class="btn-secondary w-full" @click="copyText">
                  <ClipboardIcon class="h-4.5 w-4.5" />
                  Copier le texte
                </button>
                <button type="button" class="btn-secondary w-full" @click="exportToWord">
                  <FileTextIcon class="h-4.5 w-4.5" />
                  Exporter en Word
                </button>
              </template>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="space-y-6 lg:col-span-2">
          <div class="surface-card p-6">
            <h2 class="mb-4 flex items-center gap-2 text-base font-bold text-slate-900">
              <EyeIcon class="h-5 w-5 text-brand-500" />
              Contenu détaillé
            </h2>

            <div v-if="contribution.type === 'texte'">
              <div class="surface-muted mb-4 p-4">
                <h3 class="mb-3 text-lg font-semibold text-slate-800">{{ contribution.titre }}</h3>
                <p class="whitespace-pre-wrap leading-relaxed text-slate-600">{{ contribution.contenu_texte }}</p>
              </div>

              <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div v-if="contribution.thematique" class="surface-muted p-3">
                  <span class="font-semibold text-brand-700">Thématique</span>
                  <p class="mt-1 text-slate-700">{{ contribution.thematique }}</p>
                </div>
                <div v-if="contribution.langue" class="rounded-2xl border border-emerald-100 bg-emerald-50 p-3">
                  <span class="font-semibold text-emerald-700">Langue</span>
                  <p class="mt-1 text-emerald-900">{{ contribution.langue }}</p>
                </div>
              </div>
            </div>

            <div v-else-if="contribution.type === 'image'" class="grid grid-cols-1 gap-4">
              <div v-if="contribution.fichiers_urls?.length" class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                <a
                  v-for="(file, index) in contribution.fichiers_urls"
                  :key="index"
                  :href="file.url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="group relative block aspect-square overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
                >
                  <img :src="file.url" :alt="`${contribution.titre} — ${index + 1}`" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                  <div class="absolute inset-0 flex items-center justify-center bg-slate-900/0 opacity-0 transition-all duration-300 group-hover:bg-slate-900/40 group-hover:opacity-100">
                    <ExpandIcon class="h-5 w-5 text-white" />
                  </div>
                </a>
              </div>
              <div v-else class="flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 p-4 text-sm text-amber-700">
                <AlertTriangleIcon class="h-5 w-5 shrink-0" />
                Aucune image trouvée sur le serveur pour cette contribution.
              </div>

              <div v-if="contribution.nature" class="surface-muted p-4">
                <span class="font-semibold text-brand-700">Nature</span>
                <p class="mt-1 text-slate-700">{{ contribution.nature }}</p>
              </div>
              <div v-if="contribution.description" class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <span class="font-semibold text-slate-700">Description</span>
                <p class="mt-1 text-slate-700">{{ contribution.description }}</p>
              </div>
              <div v-if="contribution.nom_fichier" class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                <span class="font-semibold text-emerald-700">Fichier</span>
                <p class="mt-1 text-emerald-900">{{ contribution.nom_fichier }}</p>
              </div>
            </div>

            <div v-else-if="contribution.type === 'dataset'" class="grid grid-cols-1 gap-4">
              <div v-if="contribution.fichiers_urls?.length" class="flex items-center gap-4 rounded-2xl border border-brand-100 bg-brand-50/60 p-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-gradient text-white">
                  <FileSpreadsheetIcon class="h-7 w-7" />
                </div>
                <div class="min-w-0 flex-1">
                  <p class="truncate font-semibold text-slate-900">{{ contribution.nom_fichier || contribution.fichiers_urls[0].name }}</p>
                  <p class="text-sm text-slate-500">
                    .{{ contribution.fichiers_urls[0].extension }}<span v-if="contribution.taille_fichier_formatee"> • {{ contribution.taille_fichier_formatee }}</span>
                  </p>
                </div>
                <a :href="contribution.fichiers_urls[0].url" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-sm shrink-0">
                  <EyeIcon class="h-4 w-4" />
                  Ouvrir
                </a>
              </div>
              <div v-else class="flex items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 p-4 text-sm text-amber-700">
                <AlertTriangleIcon class="h-5 w-5 shrink-0" />
                Fichier introuvable sur le serveur pour cette contribution.
              </div>

              <div v-if="contribution.domaine" class="surface-muted p-4">
                <span class="font-semibold text-brand-700">Domaine</span>
                <p class="mt-1 text-slate-700">{{ contribution.domaine }}</p>
              </div>
              <div v-if="contribution.description" class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <span class="font-semibold text-slate-700">Description</span>
                <p class="mt-1 text-slate-700">{{ contribution.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <ConfirmationModal
        :show="showConfirmation"
        :variant="confirmationAction"
        :title="confirmationAction === 'approve' ? 'Approuver la contribution' : 'Rejeter la contribution'"
        :message="`Êtes-vous sûr de vouloir ${confirmationAction === 'approve' ? 'approuver' : 'rejeter'} cette contribution ?`"
        :item-info="contributionToModerate?.titre"
        @confirm="handleModeration"
        @cancel="showConfirmation = false"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import {
  ArrowLeftIcon,
  InfoIcon,
  SettingsIcon,
  CheckIcon,
  XIcon,
  EyeIcon,
  DownloadIcon,
  ClipboardIcon,
  FileTextIcon,
  ExpandIcon,
  FileSpreadsheetIcon,
  AlertTriangleIcon,
} from 'lucide-vue-next'

const props = defineProps({
  contribution: Object,
})

const showConfirmation = ref(false)
const confirmationAction = ref('approve')
const contributionToModerate = ref(null)

const typeLabels = {
  image: 'Image',
  texte: 'Texte',
  dataset: 'Dataset',
}

const statusLabels = {
  en_attente: 'En attente',
  approuve: 'Approuvé',
  rejete: 'Rejeté',
}

const typeColors = {
  image: 'badge-brand',
  texte: 'badge-success',
  dataset: 'badge-neutral',
}

const statusColors = {
  en_attente: 'badge-warning',
  approuve: 'badge-success',
  rejete: 'badge-danger',
}

function openConfirmation(action, contribution) {
  confirmationAction.value = action
  contributionToModerate.value = contribution
  showConfirmation.value = true
}

function handleModeration() {
  const action = confirmationAction.value
  const contributionId = contributionToModerate.value.id

  if (action === 'approve') {
    router.post(`/admin/contributions/${contributionId}/approve`)
  } else {
    router.post(`/admin/contributions/${contributionId}/reject`)
  }

  showConfirmation.value = false
  router.reload()
}

function downloadFile(contribution) {
  window.open(`/admin/contributions/${contribution.id}/download`, '_blank')
}

function copyText() {
  navigator.clipboard.writeText(props.contribution.contenu_texte).catch((err) => console.error('Erreur lors de la copie:', err))
}

function exportToWord() {
  const content = `
    <html xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:w="urn:schemas-microsoft-com:office:word"
          xmlns="http://www.w3.org/TR/REC-html40">
      <head>
        <meta charset="UTF-8">
        <title>${props.contribution.titre}</title>
        <style>
          body { font-family: Arial, sans-serif; line-height: 1.6; margin: 2cm; }
          h1 { color: #02609f; }
          p { margin-bottom: 1em; }
        </style>
      </head>
      <body>
        <h1>${props.contribution.titre}</h1>
        <div>${props.contribution.contenu_texte.replace(/\n/g, '</div><div>')}</div>
      </body>
    </html>
  `

  const blob = new Blob([content], { type: 'application/msword' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = `${props.contribution.titre.replace(/[^a-z0-9]/gi, '_')}.doc`
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
  URL.revokeObjectURL(link.href)
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
</script>
