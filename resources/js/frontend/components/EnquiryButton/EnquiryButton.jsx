"use client";
import { Localized } from "@/components/Language/Language";
import { useEffect, useId, useRef, useState } from "react";
import { createPortal } from "react-dom";
import Arrow from "@/components/Arrow/Arrow";
import styles from "./EnquiryButton.module.css";
import EnquiryForm from "./EnquiryForm";

export default function EnquiryButton({ children = "Let's talk", className = "text-link", context = "" }) {
  const [open, setOpen] = useState(false);
  const dialog = useRef(null);
  const trigger = useRef(null);
  const titleId = useId();
  useEffect(() => {
    if (!open) return;
    const element = dialog.current;
    const previous = document.body.style.overflow;
    element.showModal();
    document.body.style.overflow = "hidden";
    const opener = trigger.current;
    return () => { element.close(); document.body.style.overflow = previous; opener?.focus({ preventScroll: true }); };
  }, [open]);
  return <Localized><>
    <button ref={trigger} type="button" className={`${styles.trigger} ${className}`} aria-haspopup="dialog" onClick={() => setOpen(true)}>{children}<Arrow diagonal /></button>
    {open && createPortal(<Localized><dialog ref={dialog} className={styles.dialog} aria-labelledby={titleId} onClose={() => setOpen(false)} onClick={event => { if (event.target === event.currentTarget) { const r = event.currentTarget.getBoundingClientRect(); if (event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom) setOpen(false); } }}>
      <button type="button" className={styles.close} aria-label="Close enquiry" onClick={() => setOpen(false)}>×</button>
      <p className={styles.eyebrow}>FIBRO / START A CONVERSATION</p>
      <h2 id={titleId}>What can we<br /><em>create together?</em></h2>
      <p className={styles.intro}>{context ? `Let’s find the right construction for ${context.toLowerCase()}.` : "From a first idea to the right material. Tell us what you need."}</p>
      <EnquiryForm context={context} />
    </dialog></Localized>, document.body)}
  </></Localized>;
}
