import test from 'node:test'
import assert from 'node:assert/strict'

import { createErrorReporter, getErrorDetails } from '../resources/js/utils/errorGuard.js'

test('getErrorDetails formats native Error objects', () => {
  const error = new Error('boom')
  const details = getErrorDetails(error, 'home-page')

  assert.equal(details.context, 'home-page')
  assert.equal(details.name, 'Error')
  assert.equal(details.message, 'boom')
  assert.ok(details.stack.includes('Error: boom'))
})

test('createErrorReporter returns a handler that reports and stops propagation', () => {
  const reporter = createErrorReporter('bootstrap')
  const handled = reporter(new Error('handled'))

  assert.equal(handled, false)
})
