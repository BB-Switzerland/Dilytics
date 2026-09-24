// /llms.txt, written against the origin that serves it.
import { llmsTxt } from '../../app/content/llms.js'

export default defineEventHandler((event) => {
  setResponseHeader(event, 'Content-Type', 'text/plain; charset=utf-8')
  return llmsTxt(getRequestURL(event).origin)
})
