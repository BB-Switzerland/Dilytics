import { CONTACT } from '~/content/site'

// The site has no mail server behind it, so a form does not pretend to send:
// it opens the visitor's own mail client with the message addressed to the
// cabinet, ready to go. Replace with a real sending service once there is one.
export function mailDraft({ subject, name, mail, phone, msg }) {
  const sign = [name, mail, phone].map((v) => v?.trim()).filter(Boolean).join('\n')
  const body = `${msg.trim()}\n\n${sign}`
  return `mailto:${CONTACT.mail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`
}
