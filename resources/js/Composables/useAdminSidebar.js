import { ref } from 'vue'

// Module-level state so the AdminHeader's burger button and the
// AdminSidebar drawer always stay in sync, without prop-drilling.
const sidebarOpen = ref(false)

export function useAdminSidebar() {
  const open = () => (sidebarOpen.value = true)
  const close = () => (sidebarOpen.value = false)
  const toggle = () => (sidebarOpen.value = !sidebarOpen.value)

  return { sidebarOpen, open, close, toggle }
}
