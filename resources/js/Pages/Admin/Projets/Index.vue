<!-- resources/js/Pages/Admin/Projets/Index.vue -->
<template>
  <AdminLayout title="Gestion des projets" description="Créez et gérez les projets du club">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-medium text-slate-500">{{ projets.length }} projet(s)</p>
        <Link href="/admin/projets/create" class="btn-primary">
          <PlusIcon class="h-4.5 w-4.5" />
          Nouveau projet
        </Link>
      </div>

      <div class="surface-card overflow-x-auto">
        <table class="table-admin">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Catégorie</th>
              <th>Statut</th>
              <th>Équipe</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="projet in projets" :key="projet.id">
              <td class="font-semibold text-slate-800">{{ projet.titre }}</td>
              <td><span class="badge" :class="getCategoryColor(projet.categorie)">{{ projet.categorie }}</span></td>
              <td><span class="badge" :class="getStatusColor(projet.statut)">{{ projet.statut }}</span></td>
              <td>{{ projet.equipe || 'Non spécifiée' }}</td>
              <td>
                <div class="flex items-center justify-end gap-1.5">
                  <Link :href="`/admin/projets/${projet.id}/edit`" class="btn-icon h-8 w-8" aria-label="Modifier">
                    <PencilIcon class="h-4 w-4" />
                  </Link>
                  <button type="button" class="flex h-8 w-8 items-center justify-center rounded-lg text-rose-600 transition-colors hover:bg-rose-50" aria-label="Supprimer" @click="confirmDelete(projet)">
                    <TrashIcon class="h-4 w-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="projets.length === 0" class="py-14 text-center">
          <FolderOpenIcon class="mx-auto mb-3 h-10 w-10 text-brand-200" />
          <p class="text-sm text-slate-500">Aucun projet trouvé</p>
          <Link href="/admin/projets/create" class="mt-2 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">
            Créer votre premier projet
          </Link>
        </div>
      </div>
    </div>

    <ConfirmationModal
      :show="showDeleteModal"
      variant="delete"
      title="Supprimer le projet"
      message="Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est irréversible."
      :item-info="projetToDelete?.titre"
      @confirm="deleteProjet"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import { FolderOpenIcon, PencilIcon, PlusIcon, TrashIcon } from 'lucide-vue-next'

const props = defineProps({
  projets: Array,
})

const showDeleteModal = ref(false)
const projetToDelete = ref(null)

const categoryColors = {
  Recherche: 'badge-brand',
  Éducation: 'badge-neutral',
  Culturel: 'bg-fuchsia-100 text-fuchsia-700',
  Santé: 'badge-success',
  Agriculture: 'badge-warning',
  NLP: 'bg-violet-100 text-violet-700',
  'Vision par Ordinateur': 'badge-danger',
  Robotique: 'badge-neutral',
}

const statusColors = {
  Terminé: 'badge-success',
  'En cours': 'badge-brand',
  Planifié: 'badge-warning',
}

const getCategoryColor = (categorie) => categoryColors[categorie] || 'badge-neutral'
const getStatusColor = (statut) => statusColors[statut] || 'badge-neutral'

const confirmDelete = (projet) => {
  projetToDelete.value = projet
  showDeleteModal.value = true
}

const deleteProjet = () => {
  if (projetToDelete.value) {
    router.delete(`/admin/projets/${projetToDelete.value.id}`)
  }
  showDeleteModal.value = false
  projetToDelete.value = null
}
</script>
