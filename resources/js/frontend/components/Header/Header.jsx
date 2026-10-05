"use client";
import { Localized } from "@/components/Language/Language";
import { useEffect, useId, useRef, useState } from "react";
import Arrow from "@/components/Arrow/Arrow";
import EnquiryButton from "@/components/EnquiryButton/EnquiryButton";
import Brand from "@/components/Brand/Brand";
import LanguageMenu from "@/components/Language/Language";
import styles from "./Header.module.css";
import { sitePath, siteUrl } from "@/utils/siteUrl";

const links = [
  ["Products", "/products"],
  ["Services", "/services"],
  ["Technology", "/technology"],
  ["Circular textiles", "/circular-textiles"],
];
const aboutLinks = [
  ["About Fibro", "/about"],
  ["Manufacturing & Quality", "/manufacturing-quality"],
  ["Environment & Sustainability", "/sustainability"],
];

function AboutNavigation({ mobile = false, onNavigate, currentPath }) {
  const [expanded, setExpanded] = useState(false);
  const root = useRef(null);
  const trigger = useRef(null);
  const id = useId();
  useEffect(() => {
    if (!expanded) return;
    const outside = event => { if (!root.current?.contains(event.target)) setExpanded(false); };
    const resize = () => setExpanded(false);
    document.addEventListener('pointerdown', outside);
    window.addEventListener('resize', resize);
    return () => { document.removeEventListener('pointerdown', outside); window.removeEventListener('resize', resize); };
  }, [expanded]);
  function keyboard(event) {
    if (event.key === 'Escape' && expanded) {
      event.preventDefault(); event.stopPropagation(); setExpanded(false); trigger.current?.focus();
    }
  }
  return <Localized><div ref={root} className={`${styles.aboutNavigation} ${mobile ? styles.aboutMobile : ''}`} onKeyDown={keyboard} onBlur={event => { if (!event.currentTarget.contains(event.relatedTarget)) setExpanded(false); }}>
    <button ref={trigger} type="button" className={styles.aboutTrigger} data-active={aboutLinks.some(([, href]) => currentPath === href)} aria-expanded={expanded} aria-controls={id} onClick={() => setExpanded(!expanded)}>About Fibro<svg width="12" height="12" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m4 6 4 4 4-4" stroke="currentColor" strokeWidth="1.5" /></svg></button>
    <div id={id} className={styles.aboutPanel} hidden={!expanded}>
      {aboutLinks.map(([label,href]) => <a key={href} href={siteUrl(href)} aria-current={currentPath === href ? "page" : undefined} onClick={() => { setExpanded(false); onNavigate?.(); }}>{label}<Arrow diagonal /></a>)}
    </div>
  </div></Localized>;
}
export default function Header() {
  const [open, setOpen] = useState(false);
  const [currentPath, setCurrentPath] = useState("");
  const button = useRef(null);
  const header = useRef(null);
  useEffect(() => {
    setCurrentPath(sitePath(window.location.pathname));
    const desktop = window.matchMedia("(min-width: 1201px)");
    const closeOnDesktop = () => { if (desktop.matches) setOpen(false); };
    const closeOutside = event => { if (!header.current?.contains(event.target) && !event.target.closest("dialog")) setOpen(false); };
    desktop.addEventListener("change", closeOnDesktop);
    document.addEventListener("pointerdown", closeOutside);
    return () => { desktop.removeEventListener("change", closeOnDesktop); document.removeEventListener("pointerdown", closeOutside); };
  }, []);
  function escape(event) {
    if (event.target.closest("dialog")) return;
    if (event.key === "Escape" && open) { setOpen(false); button.current?.focus(); }
  }
  return <Localized><>
    <a href="#main-content" className="skip-link">Skip to content</a>
    <header ref={header} className={styles.header} onKeyDown={escape}>
      <div className={`container ${styles.inner}`}>
        <Brand />
        <nav className={styles.desktop} aria-label="Main navigation">{links.map(([label, href]) => {
          const active = currentPath === href || currentPath.startsWith(`${href}/`);
          return <a key={href} href={siteUrl(href)} aria-current={currentPath === href ? "page" : active ? "location" : undefined}>{label}</a>;
        })}<AboutNavigation currentPath={currentPath} /></nav>
        <EnquiryButton className={styles.contact}>Let&apos;s talk</EnquiryButton>
        <LanguageMenu />
        <button type="button" ref={button} className={styles.toggle} aria-expanded={open} aria-controls="mobile-navigation" aria-label={open ? "Close navigation" : "Open navigation"} onClick={() => setOpen(!open)}><span>{open ? "Close" : "Menu"}</span><span aria-hidden="true">{open ? "−" : "+"}</span></button>
      </div>
      <nav id="mobile-navigation" className={styles.mobile} aria-label="Mobile navigation" hidden={!open}>
        {links.map(([label,href]) => {
          const active = currentPath === href || currentPath.startsWith(`${href}/`);
          return <a key={href} href={siteUrl(href)} aria-current={currentPath === href ? "page" : active ? "location" : undefined} onClick={() => setOpen(false)}>{label}<Arrow diagonal /></a>;
        })}
        <AboutNavigation key={String(open)} mobile currentPath={currentPath} onNavigate={() => setOpen(false)} />
        <a href={siteUrl("/contact")} onClick={() => setOpen(false)}>Contact Fibro<Arrow diagonal /></a>
        <EnquiryButton className={styles.mobileContact}>Let&apos;s talk</EnquiryButton>
      </nav>
    </header>
  </></Localized>;
}
