export function getErrorDetails(error, context = 'app') {
  if (error instanceof Error) {
    return {
      context,
      name: error.name,
      message: error.message,
      stack: error.stack || '',
    }
  }

  return {
    context,
    name: typeof error,
    message: String(error),
    stack: '',
  }
}

export function createErrorReporter(context = 'app') {
  return (error) => {
    console.error(`[${context}]`, getErrorDetails(error, context))
    return false
  }
}

export function installGlobalErrorHandlers(context = 'app') {
  if (typeof window === 'undefined') {
    return
  }

  const report = createErrorReporter(context)

  const isIgnoredErrorMessage = (value = '') => {
    const text = String(value || '').toLowerCase()

    return /(^chrome-extension:|^moz-extension:|^safari-extension:|contentscript\.js|sentry\.init|script error\.|blocked a frame|cannot load script|window error|resizeobserver loop limit exceeded)/.test(text)
  }

  const isExtensionError = (event) => {
    const filename = event.filename || ''
    const message = event.message || ''

    return isIgnoredErrorMessage(filename + message)
  }

  const getErrorFromEvent = (event) => {
    if (event?.error instanceof Error) {
      return event.error
    }

    if (typeof event?.message === 'string' && event.message.trim()) {
      const message = event.message.trim()
      if (isIgnoredErrorMessage(message)) {
        return null
      }

      return new Error(message)
    }

    return null
  }

  window.addEventListener('error', (event) => {
    if (isExtensionError(event)) {
      return
    }

    const error = getErrorFromEvent(event)
    if (!error) {
      return
    }

    report(error)
  }, true)

  window.addEventListener('unhandledrejection', (event) => {
    const reason = event.reason
    if (!reason) {
      return
    }

    const message = reason && typeof reason === 'object' && reason.message ? reason.message : String(reason)
    if (isIgnoredErrorMessage(message)) {
      return
    }

    report(reason)
  })
}
