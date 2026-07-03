import './bootstrap'
import '../css/app.css'

import { createApp, h, onErrorCaptured, ref } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import AppLayout from './Layouts/AppLayout.vue'
import vReveal from './directives/reveal'
import { createErrorReporter, installGlobalErrorHandlers } from './utils/errorGuard'

const appName = import.meta.env.VITE_APP_NAME || 'Club IA-ENSPD'

installGlobalErrorHandlers('app-bootstrap')

const ErrorBoundary = {
  setup(_, { slots }) {
    const error = ref(null)
    const report = createErrorReporter('app-render')

    onErrorCaptured((err) => {
      error.value = err
      report(err)
      return false
    })

    return () => {
      if (error.value) {
        return h('div', {
          class: 'min-h-screen bg-slate-50 px-6 py-16 text-slate-700',
        }, [
          h('div', { class: 'mx-auto max-w-2xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm' }, [
            h('p', { class: 'text-sm font-semibold uppercase tracking-[0.3em] text-sky-600' }, 'Lecture du site interrompue'),
            h('h1', { class: 'mt-3 text-2xl font-bold text-slate-900' }, 'Une erreur inattendue a bloqué l’affichage de cette section.'),
            h('p', { class: 'mt-4 text-base leading-7 text-slate-600' }, 'Actualisez la page. Si le problème persiste, le contenu sera disponible après correction du conflit ou du script tiers.'),
          ]),
        ])
      }

      return slots.default?.()
    }
  },
}

// Lightweight top-loading bar on every Inertia navigation, styled to match
// the brand gradient (see #nprogress in app.css), so navigating between
// pages always feels instant and alive.
let progressTimeout = null
router.on('start', () => {
  progressTimeout = setTimeout(() => document.documentElement.classList.add('is-navigating'), 80)
})
router.on('finish', () => {
  clearTimeout(progressTimeout)
  document.documentElement.classList.remove('is-navigating')
})

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) => {
    const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))

    page.then((module) => {
      // Every page gets the public AppLayout unless it already defines its
      // own layout (admin pages) or opts out explicitly.
      if (!module.default.layout && !name.startsWith('Admin/')) {
        module.default.layout = AppLayout
      }
      return module
    })

    return page
  },
  setup({ el, App, props, plugin }) {
    return createApp({
      render: () => h(ErrorBoundary, null, {
        default: () => h(App, props),
      }),
    })
      .use(plugin)
      .directive('reveal', vReveal)
      .mount(el)
  },
})
