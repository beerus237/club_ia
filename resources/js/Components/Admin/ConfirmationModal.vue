<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition-opacity duration-200"
      leave-active-class="transition-opacity duration-150"
      enter-from-class="opacity-0"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm" @click.self="$emit('cancel')">
        <Transition
          appear
          enter-active-class="transition-all duration-200 ease-smooth"
          enter-from-class="opacity-0 scale-95"
        >
          <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-card-hover">
            <div class="p-6 text-center">
              <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl" :class="iconWrapClass">
                <component :is="icon" class="h-7 w-7" :class="iconClass" />
              </div>

              <h3 class="mt-4 text-lg font-bold text-slate-900">{{ title }}</h3>
              <p class="mt-2 text-sm leading-6 text-slate-500">{{ message }}</p>

              <div v-if="itemInfo" class="mt-4 rounded-xl border border-brand-100 bg-brand-50/60 p-3 text-left text-sm font-medium text-slate-700">
                {{ itemInfo }}
              </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50/60 p-4">
              <button type="button" class="btn-secondary flex-1" @click="$emit('cancel')">
                {{ cancelLabel }}
              </button>
              <button type="button" class="btn flex-1 text-white" :class="confirmButtonClass" @click="$emit('confirm')">
                {{ confirmLabelResolved }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed } from 'vue'
import { AlertTriangleIcon, CheckCircle2Icon, TrashIcon, XCircleIcon } from 'lucide-vue-next'

const props = defineProps({
  show: {
    type: Boolean,
    default: true,
  },
  // approve | reject | delete | warning
  variant: {
    type: String,
    default: 'warning',
  },
  title: {
    type: String,
    default: 'Confirmer l’action',
  },
  message: {
    type: String,
    default: 'Êtes-vous sûr de vouloir continuer ?',
  },
  itemInfo: String,
  confirmLabel: String,
  cancelLabel: {
    type: String,
    default: 'Annuler',
  },
})

defineEmits(['confirm', 'cancel'])

const variants = {
  approve: {
    icon: CheckCircle2Icon,
    iconWrap: 'bg-emerald-100',
    icon_: 'text-emerald-600',
    button: 'bg-emerald-600 hover:bg-emerald-700 shadow-soft',
    label: 'Oui, approuver',
  },
  reject: {
    icon: XCircleIcon,
    iconWrap: 'bg-rose-100',
    icon_: 'text-rose-600',
    button: 'bg-rose-600 hover:bg-rose-700 shadow-soft',
    label: 'Oui, rejeter',
  },
  delete: {
    icon: TrashIcon,
    iconWrap: 'bg-rose-100',
    icon_: 'text-rose-600',
    button: 'bg-rose-600 hover:bg-rose-700 shadow-soft',
    label: 'Oui, supprimer',
  },
  warning: {
    icon: AlertTriangleIcon,
    iconWrap: 'bg-amber-100',
    icon_: 'text-amber-600',
    button: 'bg-amber-600 hover:bg-amber-700 shadow-soft',
    label: 'Confirmer',
  },
}

const current = computed(() => variants[props.variant] || variants.warning)
const icon = computed(() => current.value.icon)
const iconWrapClass = computed(() => current.value.iconWrap)
const iconClass = computed(() => current.value.icon_)
const confirmButtonClass = computed(() => current.value.button)
const confirmLabelResolved = computed(() => props.confirmLabel || current.value.label)
</script>
