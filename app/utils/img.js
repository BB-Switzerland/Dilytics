const files = import.meta.glob('~/assets/img/*.webp', { eager: true, import: 'default' })
const map = Object.fromEntries(
  Object.entries(files).map(([k, v]) => [k.split('/').pop().replace('.webp', ''), v]),
)

export function img(name) {
  return map[name]
}
