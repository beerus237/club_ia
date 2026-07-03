<template>
  <AdminLayout title="Paramètres" description="Gérez les accès et la sécurité de l'espace admin">
    <div class="mx-auto max-w-2xl">
      <div class="surface-card p-6 sm:p-8">
        <header class="mb-6 flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100">
            <KeyRoundIcon class="h-5 w-5 text-brand-600" />
          </div>
          <div>
            <h2 class="text-base font-bold text-slate-900">Mot de passe administrateur</h2>
            <p class="text-sm text-slate-500">Ce mot de passe protège l'accès à tout l'espace d'administration.</p>
          </div>
        </header>

        <form class="space-y-5" @submit.prevent="submit">
          <div>
            <label class="field-label">Mot de passe actuel</label>
            <input v-model="form.current_password" type="password" required class="field-input" autocomplete="current-password" />
            <p v-if="form.errors.current_password" class="field-error">{{ form.errors.current_password }}</p>
          </div>

          <div>
            <label class="field-label">Nouveau mot de passe</label>
            <input v-model="form.new_password" type="password" required minlength="6" class="field-input" autocomplete="new-password" />
            <p class="field-hint">6 caractères minimum</p>
            <p v-if="form.errors.new_password" class="field-error">{{ form.errors.new_password }}</p>
          </div>

          <div>
            <label class="field-label">Confirmer le nouveau mot de passe</label>
            <input v-model="form.new_password_confirmation" type="password" required class="field-input" autocomplete="new-password" />
          </div>

          <div class="flex items-center gap-4 border-t border-slate-100 pt-5">
            <button type="submit" class="btn-primary" :disabled="form.processing">
              {{ form.processing ? 'Mise à jour…' : 'Mettre à jour le mot de passe' }}
            </button>

            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p v-if="justSaved" class="flex items-center gap-1.5 text-sm font-medium text-emerald-600">
                <CheckCircle2Icon class="h-4 w-4" />
                Mis à jour.
              </p>
            </Transition>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { CheckCircle2Icon, KeyRoundIcon } from 'lucide-vue-next'

const page = usePage()
const justSaved = ref(false)

const form = useForm({
  current_password: '',
  new_password: '',
  new_password_confirmation: '',
})

const submit = () => {
  form.post('/admin/settings/password', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      justSaved.value = true
      setTimeout(() => (justSaved.value = false), 3000)
    },
  })
}
</script>
