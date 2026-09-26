export default function SocialIcon({ name }) {
  const props = { width: 22, height: 22, viewBox: "0 0 24 24", fill: "none", "aria-hidden": true };
  if (name === "Instagram") return <svg {...props}><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" strokeWidth="1.8"/><circle cx="12" cy="12" r="4" stroke="currentColor" strokeWidth="1.8"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></svg>;
  if (name === "LinkedIn") return <svg {...props}><rect x="2" y="2" width="20" height="20" rx="2" fill="currentColor"/><path d="M6 10h2.6v8H6zm1.3-4.3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10.5 10H13v1.1c.5-.8 1.3-1.3 2.5-1.3 2.6 0 3 1.7 3 4V18H16v-3.7c0-1.1 0-2.4-1.4-2.4S13 13 13 14.2V18h-2.5Z" fill="var(--color-navy)"/></svg>;
  if (name === "Facebook") return <svg {...props}><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.7-3.9 1.1 0 2.2.2 2.2.2v2.5H15c-1.2 0-1.5.7-1.5 1.5V12h2.7l-.4 2.9h-2.3v7A10 10 0 0 0 22 12Z" fill="currentColor"/></svg>;
  return null;
}
