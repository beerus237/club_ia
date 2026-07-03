<!-- resources/js/Pages/Admin/Actualites/Index.vue -->
<template>
  <AdminLayout title="Gestion des actualités" description="Créez et gérez les actualités du site">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-medium text-slate-500">{{ filteredActualites.length }} actualité(s)</p>
        <Link href="/admin/actualites/create" class="btn-primary">
          <PlusIcon class="h-4.5 w-4.5" />
          Nouvelle actualité
        </Link>
      </div>

      <div class="surface-card overflow-x-auto">
        <table class="table-admin">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Catégorie</th>
              <th>Date</th>
              <th>Statut</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="actualite in filteredActualites" :key="actualite.id">
              <td class="font-semibold text-slate-800">{{ actualite.titre || 'Sans titre' }}</td>
              <td>{{ actualite.categorie || 'Non catégorisé' }}</td>
              <td>{{ formatDate(actualite.date_publication) }}</td>
              <td>
                <span class="badge" :class="actualite.est_publie ? 'badge-success' : 'badge-neutral'">
                  {{ actualite.est_publie ? 'Publié' : 'Brouillon' }}
                </span>
              </td>
              <td>
                <div v-if="actualite.id" class="flex items-center justify-end gap-1.5">
                  <Link :href="`/admin/actualites/${actualite.id}/edit`" class="btn-icon h-8 w-8" aria-label="Modifier">
                    <PencilIcon class="h-4 w-4" />
                  </Link>
                  <button type="button" class="flex h-8 w-8 items-center justify-center rounded-lg text-rose-600 transition-colors hover:bg-rose-50" aria-label="Supprimer" @click="confirmDelete(actualite)">
                    <TrashIcon class="h-4 w-4" />
                  </button>
                </div>
                <span v-else class="text-xs text-slate-400">Actions indisponibles</span>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="filteredActualites.length === 0" class="py-14 text-center">
          <NewspaperIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
          <p class="text-sm text-slate-500">Aucune actualité trouvée</p>
          <Link href="/admin/actualites/create" class="mt-2 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">
            Créer votre première actualité
          </Link>
        </div>
      </div>

      <div v-if="hasCorruptedData" class="flex items-start gap-2.5 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
        <AlertTriangleIcon class="mt-0.5 h-4.5 w-4.5 shrink-0" />
        Certaines actualités comportent des données incomplètes et ne sont pas affichées.
      </div>
    </div>

    <ConfirmationModal
      :show="showDeleteModal"
      variant="delete"
      title="Supprimer l'actualité"
      message="Êtes-vous sûr de vouloir supprimer cette actualité ? Cette action est irréversible."
      :item-info="actualiteToDelete?.titre"
      @confirm="deleteActualite"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import { AlertTriangleIcon, NewspaperIcon, PencilIcon, PlusIcon, TrashIcon } from 'lucide-vue-next'

const props = defineProps({
  actualites: {
    type: Array,
    default: () => [],
  },
})

const filteredActualites = computed(() => props.actualites.filter((a) => a !== null && a.id !== null && a.id !== undefined))
const hasCorruptedData = computed(() => props.actualites.length > filteredActualites.value.length)

const showDeleteModal = ref(false)
const actualiteToDelete = ref(null)

function confirmDelete(actualite) {
  actualiteToDelete.value = actualite
  showDeleteModal.value = true
}

function deleteActualite() {
  if (actualiteToDelete.value) {
    router.delete(`/admin/actualites/${actualiteToDelete.value.id}`)
  }
  showDeleteModal.value = false
}

function formatDate(date) {
  if (!date) return 'Date non définie'
  return new Date(date).toLocaleDateString('fr-FR')
}
</script>
