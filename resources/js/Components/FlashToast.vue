<template>
  <Teleport to="body">
    <div class="pointer-events-none fixed bottom-6 right-6 z-[100] flex flex-col gap-3">
      <TransitionGroup
        enter-active-class="transition-all duration-300 ease-smooth"
        leave-active-class="transition-all duration-200 ease-in"
        enter-from-class="opacity-0 translate-y-4"
        leave-to-class="opacity-0 translate-y-4"
      >
        <div
          v-for="toast in toasts"
          :key="toast.id"
          class="pointer-events-auto flex max-w-sm items-start gap-3 rounded-2xl p-4 shadow-card-hover"
          :class="toast.type === 'error' ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white'"
        >
          <component :is="toast.type === 'error' ? XCircleIcon : CheckCircle2Icon" class="mt-0.5 h-5 w-5 shrink-0" />
          <p class="text-sm font-medium leading-6">{{ toast.message }}</p>
          <button type="button" class="ml-auto shrink-0 opacity-70 hover:opacity-100" @click="dismiss(toast.id)">
            <XIcon class="h-4 w-4" />
          </button>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { CheckCircle2Icon, XCircleIcon, XIcon } from 'lucide-vue-next'

const page = usePage()
const toasts = ref([])
let nextId = 0

function push(message, type) {
  const id = nextId++
  toasts.value.push({ id, message, type })
  setTimeout(() => dismiss(id), 5000)
}

function dismiss(id) {
  toasts.value = toasts.value.filter((t) => t.id !== id)
}

watch(
  () => page.props.flash?.success,
  (message) => {
    if (message) push(message, 'success')
  }
)

watch(
  () => page.props.flash?.error,
  (message) => {
    if (message) push(message, 'error')
  }
)
</script>
