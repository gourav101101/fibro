"use client";
import { useEffect, useRef } from "react";

export default function Reveal({ children, className = "" }) {
  const ref = useRef(null);
  useEffect(() => {
    const el = ref.current;
    const preference = window.matchMedia("(prefers-reduced-motion: reduce)");
    if (!el || preference.matches || !("IntersectionObserver" in window)) return;
    let animation;
    const observer = new IntersectionObserver(([entry]) => {
      if (!entry.isIntersecting) return;
      animation = el.animate([{ opacity: 0, transform: "translateY(20px)" }, { opacity: 1, transform: "translateY(0)" }], { duration: 550, easing: "cubic-bezier(.2,.7,.2,1)" });
      observer.disconnect();
    }, { threshold: 0.08 });
    const stop = () => { if (preference.matches) { observer.disconnect(); animation?.cancel(); } };
    preference.addEventListener("change", stop);
    observer.observe(el);
    return () => { observer.disconnect(); animation?.cancel(); preference.removeEventListener("change", stop); };
  }, []);
  return <div ref={ref} className={className}>{children}</div>;
}
