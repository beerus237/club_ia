<!-- resources/js/Pages/Admin/Evenements/Index.vue -->
<template>
  <AdminLayout title="Gestion des événements" description="Créez et gérez les événements du club">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-medium text-slate-500">{{ evenements.length }} événement(s)</p>
        <Link href="/admin/evenements/create" class="btn-primary">
          <PlusIcon class="h-4.5 w-4.5" />
          Nouvel événement
        </Link>
      </div>

      <div class="surface-card overflow-x-auto">
        <table class="table-admin">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Date</th>
              <th>Lieu</th>
              <th>Statut</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="evenement in evenements" :key="evenement.id">
              <td class="font-semibold text-slate-800">{{ evenement.titre }}</td>
              <td class="whitespace-nowrap">
                {{ formatDate(evenement.date_debut) }}
                <span v-if="evenement.date_fin"> – {{ formatDate(evenement.date_fin) }}</span>
              </td>
              <td>{{ evenement.lieu }}</td>
              <td>
                <span class="badge" :class="evenement.est_actif ? 'badge-success' : 'badge-neutral'">
                  {{ evenement.est_actif ? 'Actif' : 'Inactif' }}
                </span>
              </td>
              <td>
                <div class="flex items-center justify-end gap-1.5">
                  <Link :href="`/admin/evenements/${evenement.id}/edit`" class="btn-icon h-8 w-8" aria-label="Modifier">
                    <PencilIcon class="h-4 w-4" />
                  </Link>
                  <button type="button" class="flex h-8 w-8 items-center justify-center rounded-lg text-rose-600 transition-colors hover:bg-rose-50" aria-label="Supprimer" @click="confirmDelete(evenement)">
                    <TrashIcon class="h-4 w-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="evenements.length === 0" class="py-14 text-center">
          <CalendarIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
          <p class="text-sm text-slate-500">Aucun événement trouvé</p>
          <Link href="/admin/evenements/create" class="mt-2 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">
            Créer votre premier événement
          </Link>
        </div>
      </div>
    </div>

    <ConfirmationModal
      :show="showDeleteModal"
      variant="delete"
      title="Supprimer l'événement"
      message="Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible."
      :item-info="evenementToDelete?.titre"
      @confirm="deleteEvenement"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import { CalendarIcon, PencilIcon, PlusIcon, TrashIcon } from 'lucide-vue-next'

defineProps({
  evenements: Array,
})

const showDeleteModal = ref(false)
const evenementToDelete = ref(null)

function confirmDelete(evenement) {
  evenementToDelete.value = evenement
  showDeleteModal.value = true
}

function deleteEvenement() {
  if (evenementToDelete.value) {
    router.delete(`/admin/evenements/${evenementToDelete.value.id}`)
  }
  showDeleteModal.value = false
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}
</script>
