<!-- resources/js/Pages/Admin/Contributions/Index.vue -->
<template>
  <AdminLayout
    title="Modération des contributions"
    description="Gérez et modérez les contributions soumises par la communauté"
  >
    <div class="space-y-6">
      <!-- En-tête avec statistiques -->
      <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
          <h1 class="text-xl font-bold text-slate-900">{{ contributions.total }} contribution(s) au total</h1>
        </div>
        <div class="flex flex-wrap gap-2">
          <span class="badge-warning">
            <ClockIcon class="h-3.5 w-3.5" />
            En attente : {{ pendingCount }}
          </span>
          <span class="badge-success">
            <CheckCircle2Icon class="h-3.5 w-3.5" />
            Approuvées : {{ approvedCount }}
          </span>
          <span class="badge-danger">
            <XCircleIcon class="h-3.5 w-3.5" />
            Rejetées : {{ rejectedCount }}
          </span>
        </div>
      </div>

      <!-- Filtres -->
      <div class="surface-card flex flex-wrap items-center gap-3 p-4">
        <SlidersHorizontalIcon class="h-4 w-4 shrink-0 text-brand-500" />
        <select v-model="filters.type" class="field-input w-auto py-2">
          <option value="">Tous les types</option>
          <option value="image">Images</option>
          <option value="texte">Textes</option>
          <option value="dataset">Datasets</option>
        </select>

        <select v-model="filters.statut" class="field-input w-auto py-2">
          <option value="">Tous les statuts</option>
          <option value="en_attente">En attente</option>
          <option value="approuve">Approuvé</option>
          <option value="rejete">Rejeté</option>
        </select>

        <button type="button" class="btn-ghost btn-sm ml-auto" @click="resetFilters">
          <RotateCcwIcon class="h-4 w-4" />
          Réinitialiser
        </button>
      </div>

      <!-- Tableau des contributions -->
      <div class="surface-card overflow-x-auto">
        <table class="table-admin">
          <thead>
            <tr>
              <th>Type</th>
              <th>Titre</th>
              <th>Soumis par</th>
              <th>Date</th>
              <th>Statut</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="contribution in filteredContributions" :key="contribution.id">
              <td>
                <span class="badge" :class="typeColors[contribution.type]">
                  <component :is="typeIcons[contribution.type]" class="h-3.5 w-3.5" />
                  {{ typeLabels[contribution.type] }}
                </span>
              </td>
              <td class="max-w-xs">
                <div class="flex items-center gap-3">
                  <img
                    v-if="contribution.type === 'image' && contribution.fichiers_urls?.length"
                    :src="contribution.fichiers_urls[0].url"
                    :alt="contribution.titre"
                    class="h-9 w-9 shrink-0 rounded-lg border border-slate-200 object-cover"
                  />
                  <span class="truncate font-medium text-slate-800">{{ contribution.titre }}</span>
                </div>
              </td>
              <td>{{ contribution.user || 'Anonyme' }}</td>
              <td class="whitespace-nowrap">{{ formatDate(contribution.created_at) }}</td>
              <td>
                <span class="badge" :class="statusColors[contribution.statut]">
                  {{ statusLabels[contribution.statut] }}
                </span>
              </td>
              <td>
                <div class="flex items-center justify-end gap-1.5">
                  <a :href="`/admin/contributions/${contribution.id}`" class="btn-icon h-8 w-8" aria-label="Voir">
                    <EyeIcon class="h-4 w-4" />
                  </a>
                  <button
                    v-if="contribution.statut === 'en_attente'"
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-emerald-600 transition-colors hover:bg-emerald-50"
                    aria-label="Approuver"
                    @click="openConfirmation('approve', contribution)"
                  >
                    <CheckIcon class="h-4 w-4" />
                  </button>
                  <button
                    v-if="contribution.statut === 'en_attente'"
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-rose-600 transition-colors hover:bg-rose-50"
                    aria-label="Rejeter"
                    @click="openConfirmation('reject', contribution)"
                  >
                    <XIcon class="h-4 w-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="filteredContributions.length === 0" class="py-14 text-center">
          <InboxIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
          <p class="text-sm text-slate-500">Aucune contribution trouvée</p>
        </div>
      </div>

      <Pagination :links="contributions.links" />

      <!-- Modals -->
      <TextViewModal
        v-if="selectedContribution && selectedContribution.type === 'texte'"
        :contribution="selectedContribution"
        @close="selectedContribution = null"
      />

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
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import TextViewModal from '@/Components/Admin/Contributions/TextViewModal.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import Pagination from '@/Components/Admin/Pagination.vue'
import {
  CheckCircle2Icon,
  CheckIcon,
  ClockIcon,
  DatabaseIcon,
  EyeIcon,
  FileTextIcon,
  ImageIcon,
  InboxIcon,
  RotateCcwIcon,
  SlidersHorizontalIcon,
  XCircleIcon,
  XIcon,
} from 'lucide-vue-next'

const props = defineProps({
  contributions: Object,
  filters: Object,
})

const filters = ref({
  type: props.filters?.type || '',
  statut: props.filters?.statut || '',
})

const selectedContribution = ref(null)
const showConfirmation = ref(false)
const confirmationAction = ref('approve')
const contributionToModerate = ref(null)

const typeLabels = {
  image: 'Image',
  texte: 'Texte',
  dataset: 'Dataset',
}

const typeIcons = {
  image: ImageIcon,
  texte: FileTextIcon,
  dataset: DatabaseIcon,
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

const pendingCount = computed(() => props.contributions.data.filter((c) => c.statut === 'en_attente').length)
const approvedCount = computed(() => props.contributions.data.filter((c) => c.statut === 'approuve').length)
const rejectedCount = computed(() => props.contributions.data.filter((c) => c.statut === 'rejete').length)

const filteredContributions = computed(() =>
  props.contributions.data.filter((contribution) => {
    if (filters.value.type && contribution.type !== filters.value.type) return false
    if (filters.value.statut && contribution.statut !== filters.value.statut) return false
    return true
  })
)

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
}

function resetFilters() {
  filters.value = { type: '', statut: '' }
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

watch(
  filters,
  (newFilters) => {
    router.get('/admin/contributions', newFilters, {
      preserveState: true,
      replace: true,
    })
  },
  { deep: true }
)
</script>
