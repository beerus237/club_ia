<!-- resources/js/Pages/Admin/Carousel/Index.vue -->
<template>
  <AdminLayout title="Gestion du carousel" description="Configurez les slides de la page d'accueil">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-medium text-slate-500">{{ slides.length }} slide(s)</p>
        <Link href="/admin/carousel/create" class="btn-primary">
          <PlusIcon class="h-4.5 w-4.5" />
          Nouveau slide
        </Link>
      </div>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="slide in slides" :key="slide.id" class="surface-card-hover overflow-hidden">
          <div class="relative h-44 bg-brand-100">
            <img v-if="slide.image_url" :src="slide.image_url" :alt="slide.titre" class="h-full w-full object-cover" />
            <div v-else class="flex h-full w-full items-center justify-center bg-brand-gradient">
              <ImageIcon class="h-10 w-10 text-white/80" />
            </div>
            <span
              class="absolute right-2.5 top-2.5 badge backdrop-blur-sm"
              :class="slide.est_actif ? 'bg-emerald-500/90 text-white' : 'bg-slate-500/80 text-white'"
            >
              {{ slide.est_actif ? 'Actif' : 'Inactif' }}
            </span>
          </div>

          <div class="p-4">
            <h3 class="mb-1.5 truncate font-bold text-slate-900">{{ slide.titre }}</h3>
            <p class="mb-4 line-clamp-2 text-sm text-slate-500">{{ slide.description }}</p>

            <div class="flex items-center justify-between border-t border-slate-100 pt-3">
              <span class="text-xs font-medium text-slate-400">Ordre : {{ slide.ordre }}</span>
              <div class="flex items-center gap-1.5">
                <Link :href="`/admin/carousel/${slide.id}/edit`" class="btn-icon h-8 w-8" aria-label="Modifier">
                  <PencilIcon class="h-4 w-4" />
                </Link>
                <button type="button" class="flex h-8 w-8 items-center justify-center rounded-lg text-rose-600 transition-colors hover:bg-rose-50" aria-label="Supprimer" @click="confirmDelete(slide)">
                  <TrashIcon class="h-4 w-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="slides.length === 0" class="surface-card py-14 text-center">
        <ImageIcon class="mx-auto mb-4 h-12 w-12 text-brand-200" />
        <p class="mb-1 font-medium text-slate-600">Aucun slide configuré</p>
        <p class="mb-4 text-sm text-slate-400">Les visiteurs verront un carousel par défaut</p>
        <Link href="/admin/carousel/create" class="btn-primary inline-flex">
          Créer votre premier slide
        </Link>
      </div>
    </div>

    <ConfirmationModal
      :show="showDeleteModal"
      variant="delete"
      title="Supprimer le slide"
      :message="deleteMessage"
      @confirm="deleteSlide"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/Admin/ConfirmationModal.vue'
import { ImageIcon, PencilIcon, PlusIcon, TrashIcon } from 'lucide-vue-next'

const props = defineProps({
  slides: Array,
})

const showDeleteModal = ref(false)
const slideToDelete = ref(null)

const deleteMessage = computed(() => {
  if (!slideToDelete.value) return 'Êtes-vous sûr de vouloir supprimer ce slide ?'
  return `Êtes-vous sûr de vouloir supprimer le slide « ${slideToDelete.value.titre} » ?`
})

const confirmDelete = (slide) => {
  slideToDelete.value = slide
  showDeleteModal.value = true
}

const deleteSlide = () => {
  if (slideToDelete.value) {
    router.delete(`/admin/carousel/${slideToDelete.value.id}`, {
      onSuccess: () => {
        showDeleteModal.value = false
        slideToDelete.value = null
      },
    })
  }
}
</script>
