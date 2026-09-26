import { useId, useRef, useState } from 'react';
import { Localized } from '../Language/Language';
import { company } from '@/data/company';
import styles from './EnquiryButton.module.css';
import { siteUrl } from '@/utils/siteUrl';

export default function EnquiryForm({ context }) {
  const id = useId();
  const locked = useRef(false);
  const [status, setStatus] = useState('idle');
  const [errors, setErrors] = useState({});
  async function submit(event) {
    event.preventDefault();
    if (locked.current) return;
    locked.current = true;
    setStatus('sending'); setErrors({});
    const form = event.currentTarget;
    const data = Object.fromEntries(new FormData(form));
    data.material = context;
    data.locale = document.documentElement.lang;
    try {
      const response = await fetch(siteUrl('/enquiries'), {
        method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify(data),
      });
      if (response.status === 201) {
        setStatus('success');
        form.reset();
        const subject = `${data.type === 'sample' ? 'Sample request' : 'Project enquiry'} from ${data.name}`;
        const body = [
          `Name: ${data.name}`,
          `Email: ${data.email}`,
          `Company: ${data.company || 'Not provided'}`,
          `Request: ${data.type}`,
          `Material: ${data.material || 'Not provided'}`,
          '',
          'Requirements:',
          data.message,
        ].join('\n');
        window.location.href = `mailto:${company.email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
      }
      else if (response.status === 422) {
        const result = await response.json(); setErrors(result.errors ?? {}); setStatus('invalid');
        const field = Object.keys(result.errors ?? {})[0]; form.elements.namedItem(field)?.focus();
      } else setStatus(response.status === 429 ? 'limited' : response.status === 419 ? 'expired' : 'error');
    } catch { setStatus('error'); }
    finally { locked.current = false; }
  }
  return <Localized>
    {status === 'success' ? <div className={styles.success} role="status"><h3>Thank you for getting in touch.</h3><p>Your enquiry has been received. The Fibro team can now review your requirements.</p></div> :
    <form className={styles.form} onSubmit={submit}>
      <div className={styles.formGrid}>
        <label htmlFor={`${id}-name`}>Your name<input id={`${id}-name`} name="name" autoComplete="name" required maxLength={120} aria-invalid={!!errors.name} /></label>
        <label htmlFor={`${id}-email`}>Email address<input id={`${id}-email`} name="email" type="email" autoComplete="email" required maxLength={254} aria-invalid={!!errors.email} /></label>
        <label htmlFor={`${id}-company`}>Company (optional)<input id={`${id}-company`} name="company" autoComplete="organization" maxLength={160} aria-invalid={!!errors.company} /></label>
        <label htmlFor={`${id}-type`}>How can we help?<select id={`${id}-type`} name="type"><option value="project">Discuss a project</option><option value="sample">Request a sample</option></select></label>
      </div>
      <label htmlFor={`${id}-message`}>Your requirements<textarea id={`${id}-message`} name="message" rows={3} required minLength={10} maxLength={5000} placeholder="Tell us about your application, material needs and timeline." aria-invalid={!!errors.message} /></label>
      <div className={styles.honeypot} aria-hidden="true"><label>Website<input name="website" tabIndex={-1} autoComplete="off" /></label></div>
      <label className={styles.consent}><input type="checkbox" name="consent" value="1" required aria-invalid={!!errors.consent} /><span>I agree that Fibro may store these details and contact me about my enquiry.</span></label>
      <div role="status" aria-live="polite">
        {status === 'invalid' && <p>Please check the highlighted fields and try again.</p>}
        {status === 'limited' && <p>Too many attempts. Please wait a minute before trying again.</p>}
        {status === 'expired' && <p>Your session has expired. Please refresh this page before sending.</p>}
        {status === 'error' && <p>We could not save your enquiry. Please try again or contact us by email.</p>}
      </div>
      <button className={styles.submit} type="submit" disabled={status === 'sending'}>{status === 'sending' ? 'Sending…' : 'Send enquiry'} <span aria-hidden="true">↗</span></button>
    </form>}
    <p className={styles.note}>Prefer email? <a href={`mailto:${company.email}`}>{company.email}</a></p>
  </Localized>;
}
