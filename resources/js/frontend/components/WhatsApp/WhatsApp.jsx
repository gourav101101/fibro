"use client";
import { Localized } from "@/components/Language/Language";
import { useEffect, useState } from "react";
import { company } from "@/data/company";
import styles from "./WhatsApp.module.css";

export function WhatsAppIcon() {
  return <Localized><svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.4 11.7a8.4 8.4 0 0 1-12.5 7.4L3 20.5l1.4-4.8a8.4 8.4 0 1 1 16-4Z" stroke="currentColor" strokeWidth="1.6" strokeLinejoin="round"/><path d="M8.1 7.6c.2-.3.5-.3.7-.1l1.2 2c.1.2.1.4-.1.6l-.6.7c.7 1.4 1.7 2.4 3.1 3.1l.7-.8c.2-.2.4-.2.6-.1l2 1c.3.2.3.4.2.7-.4 1.1-1.2 1.6-2.3 1.4-3-.6-5.8-3.3-6.5-6.2-.2-.9.2-1.7 1-2.3Z" fill="currentColor"/></svg></Localized>;
}

export default function WhatsApp() {
  const [visible, setVisible] = useState(false);
  useEffect(() => {
    const hero = document.querySelector("main > :first-child");
    const footer = document.querySelector("footer");
    if (!hero || !footer) return;
    let heroVisible = true;
    let footerVisible = false;
    const observer = new IntersectionObserver(entries => {
      for (const entry of entries) {
        if (entry.target === hero) heroVisible = entry.isIntersecting;
        if (entry.target === footer) footerVisible = entry.isIntersecting;
      }
      setVisible(!heroVisible && !footerVisible);
    });
    observer.observe(hero); observer.observe(footer);
    return () => observer.disconnect();
  }, []);
  if (!visible) return null;
  return <Localized><a className={styles.floating} href={company.whatsappHref} target="_blank" rel="noopener noreferrer" aria-label="Chat with Fibro on WhatsApp (opens a new tab)"><WhatsAppIcon /><span>WhatsApp</span></a></Localized>;
}
