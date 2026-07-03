// Single shared IntersectionObserver used by every `v-reveal` element across
// the whole app, so scroll-in animations are 100% consistent between pages
// and we don't spin up a new observer per component.

let observer = null

function getObserver() {
  if (typeof window === 'undefined') return null

  if (!observer) {
    observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible')
            observer.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    )
  }

  return observer
}

export const vReveal = {
  mounted(el, binding) {
    el.setAttribute('data-reveal', '')

    if (binding.value?.delay) {
      el.style.transitionDelay = `${binding.value.delay}ms`
    }

    // Respect users who prefer reduced motion
    if (window.matchMedia?.('(prefers-reduced-motion: reduce)').matches) {
      el.classList.add('is-visible')
      return
    }

    getObserver()?.observe(el)
  },
  unmounted(el) {
    observer?.unobserve(el)
  },
}

export default vReveal
