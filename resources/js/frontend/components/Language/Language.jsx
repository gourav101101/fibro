"use client";
import { Children, cloneElement, isValidElement, useEffect, useId, useRef, useState, useSyncExternalStore } from "react";
import translations from "@/data/translations.json";
import styles from "./Language.module.css";

const listeners = new Set();
const supported = ["en", "hi", "fr"];
let current = "en";
function snapshot() {
  try { const saved = localStorage.getItem("fibro-language"); if (supported.includes(saved)) current = saved; } catch {}
  return current;
}
function subscribe(callback) { listeners.add(callback); window.addEventListener("storage", callback); return () => { listeners.delete(callback); window.removeEventListener("storage", callback); }; }
function useLanguage() { return useSyncExternalStore(subscribe, snapshot, () => "en"); }
function choose(language) {
  current = language;
  try { localStorage.setItem("fibro-language", language); } catch {}
  listeners.forEach(callback => callback());
}
function translate(text, language) {
  if (language === "en" || typeof text !== "string") return text;
  const key = text.trim().replace(/\s+/g, " ");
  const dictionary = translations[language];
  const translated = dictionary[key] ?? dictionary[Object.keys(dictionary).find(k => k.toLowerCase() === key.toLowerCase())];
  if (translated) return text.replace(text.trim(), translated);
  if (key.startsWith("Illustrative three-layer laminate,")) {
    const name = translate(key.split("Highlighted: ")[1]?.replace(/\.$/, "") ?? "", language);
    const bonded = key.includes(", bonded.");
    return language === "fr" ? `Schéma à trois couches ${bonded ? "assemblées" : "séparées"}. Couche sélectionnée : ${name}.` : `तीन परतों का उदाहरण, ${bonded ? "जुड़ी हुई" : "अलग"}। चुनी गई परत: ${name}।`;
  }
  const prefix = "Let’s find the right construction for ";
  if (key.startsWith(prefix)) {
    const context = translate(key.slice(prefix.length, -1), language);
    return language === "fr" ? `Trouvons la bonne construction pour : ${context}.` : `इसके लिए उपयुक्त संरचना चुनें: ${context}।`;
  }
  return text;
}
function localize(children, language) {
  return Children.map(children, child => {
    if (typeof child === "string") return translate(child, language);
    if (!isValidElement(child)) return child;
    const props = {};
    for (const name of ["alt", "aria-label", "title", "placeholder"]) if (typeof child.props[name] === "string") props[name] = translate(child.props[name], language);
    if (child.props.children !== undefined) props.children = localize(child.props.children, language);
    return cloneElement(child, props);
  });
}
export function Localized({ children }) { return localize(children, useLanguage()); }

export default function LanguageMenu() {
  const language = useLanguage();
  const [open, setOpen] = useState(false);
  const root = useRef(null);
  const trigger = useRef(null);
  const options = useRef([]);
  const panelId = useId();
  const languages = [{ code: "en", name: "English" }, { code: "hi", name: "हिन्दी" }, { code: "fr", name: "Français" }];
  const label = { en: "Website language", hi: "वेबसाइट की भाषा", fr: "Langue du site" }[language];
  useEffect(() => { document.documentElement.lang = language; }, [language]);
  useEffect(() => {
    if (!open) return;
    options.current[supported.indexOf(language)]?.focus();
    const outside = event => { if (!root.current?.contains(event.target)) setOpen(false); };
    document.addEventListener("pointerdown", outside);
    return () => document.removeEventListener("pointerdown", outside);
  }, [open, language]);
  function close() { setOpen(false); trigger.current?.focus(); }
  function keyboard(event) {
    if (event.key === "Escape" && open) { event.preventDefault(); event.stopPropagation(); close(); }
    const index = options.current.indexOf(event.target);
    if (index < 0) return;
    let next;
    if (event.key === "ArrowDown") next = (index + 1) % languages.length;
    else if (event.key === "ArrowUp") next = (index + languages.length - 1) % languages.length;
    else if (event.key === "Home") next = 0;
    else if (event.key === "End") next = languages.length - 1;
    if (next !== undefined) { event.preventDefault(); options.current[next]?.focus(); }
  }
  return <div ref={root} className={styles.control} onKeyDown={keyboard} onBlur={event => { if (!event.currentTarget.contains(event.relatedTarget)) setOpen(false); }}>
    <button ref={trigger} type="button" className={styles.trigger} aria-label={`${label}: ${languages.find(item => item.code === language).name}`} aria-expanded={open} aria-controls={panelId} onClick={() => setOpen(!open)} onKeyDown={event => { if (event.key === "ArrowDown" || event.key === "ArrowUp") { event.preventDefault(); setOpen(true); } }}>
      <svg className={styles.globe} width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" strokeWidth="1.5"/><ellipse cx="12" cy="12" rx="4" ry="9" stroke="currentColor" strokeWidth="1.5"/><path d="M3 12h18" stroke="currentColor" strokeWidth="1.5"/></svg>
      <span lang={language}>{languages.find(item => item.code === language).name}</span>
      <svg className={styles.chevron} width="12" height="12" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m4 6 4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/></svg>
    </button>
    {open && <div id={panelId} className={styles.panel} role="group" aria-label={label}>
      <p>{label}</p>
      {languages.map((item,index) => <button key={item.code} ref={node => { options.current[index] = node; }} type="button" lang={item.code} aria-pressed={language === item.code} onClick={() => { choose(item.code); close(); }}><span>{item.name}</span>{language === item.code && <svg width="18" height="18" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m4 10 4 4 8-8" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/></svg>}</button>)}
    </div>}
  </div>;
}
