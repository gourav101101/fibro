"use client";
import { Localized } from "@/components/Language/Language";
import { useRef, useState } from "react";
import Image from "@/components/Image";
import Arrow from "@/components/Arrow/Arrow";
import styles from "./HeroStory.module.css";
import { siteUrl } from "@/utils/siteUrl";

const defaultStories = [
  {
    label: "Materials with purpose", eyebrow: "FIBRO / TECHNICAL TEXTILES & LAMINATION",
    title: <>Technical fabrics.<br />Your possibilities.</>, accent: "Developed together.",
    description: "Coating, lamination and digital printing for your next product.",
    image: "/images/product-highalt.jpg", alt: "Illustrative technical textile layers with water droplets",
    action: "Explore our products", href: "#applications", dark: true,
  },
  {
    label: "Protection in every layer", eyebrow: "FIBRO / PERFORMANCE MATERIALS",
    title: <>Made for<br />the elements.</>, accent: "Ready for more.",
    description: "Protection, comfort and freedom to move. Explore technical fabric constructions developed around your application.",
    image: "/images/product-tpu.jpg", alt: "Illustrative fabric and functional membrane construction",
    action: "Explore the technology", href: "#technology", dark: true,
  },
  {
    label: "Precision in every process", eyebrow: "FIBRO / COATING & PUR LAMINATION",
    title: <>Great ideas.<br />Expertly made.</>, accent: "Layer by layer.",
    description: "Material knowledge meets precision bonding. From your first brief to a considered textile construction.",
    image: "/images/hero-precision-layers.png", alt: "Conceptual study of teal woven textile, translucent film and ivory backing meeting in a curved layered edge",
    action: "Meet the process", href: "#manufacturing", dark: true,
  },
];
const cmsStories = globalThis.__FIBRO_CMS__?.heroStories;
const stories = cmsStories?.length ? cmsStories.map(story => ({
  label: story.label, eyebrow: story.eyebrow,
  title: <>{story.title_line1}<br />{story.title_line2}</>, accent: story.accent,
  description: story.description, image: story.image, alt: story.alt,
  action: story.action_text, href: story.action_href, dark: Boolean(story.is_dark),
})) : defaultStories;

export default function HeroStory() {
  const [active, setActive] = useState(0);
  const section = useRef(null);
  function selectStory(index) {
    setActive(index);
    const hero = section.current;
    if (!hero) return;
    const rect = hero.getBoundingClientRect();
    const headerHeight = document.querySelector('header')?.getBoundingClientRect().height ?? 0;
    if (rect.height <= window.innerHeight - headerHeight + 2 && rect.top < headerHeight - 2) {
      hero.scrollIntoView({ block: 'start', behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' });
    }
  }
  const story = stories[active];
  return <Localized><section ref={section} className={`${styles.hero} ${story.dark ? styles.dark : ""}`} aria-labelledby="hero-title">
    <div className={styles.scene} key={story.image}><Image src={story.image} alt={story.alt} fill sizes="100vw" preload={active === 0} quality={90} /></div>
    <div className={styles.shade} />
    <div className={`container ${styles.content}`}>
      <div key={active} className={styles.copy} aria-live="polite" aria-atomic="true">
        <p className={styles.eyebrow}><span />{story.eyebrow}</p>
        <h1 id="hero-title">{story.title}<em>{story.accent}</em></h1>
        <p className={styles.description}>{story.description}</p>
        <a className={styles.cta} href={siteUrl(story.href)}>{story.action}<span><Arrow diagonal /></span></a>
      </div>
      <a className={styles.explore} href="#applications"><span>Discover the world of Fibro</span><span aria-hidden="true">↓</span></a>
    </div>
    <div className={styles.storyBar}><div className={`container ${styles.storyInner}`} role="group" aria-label="Choose a Fibro story">
      {stories.map((item,i)=><button type="button" key={item.label} aria-pressed={active===i} className={styles.storyButton} onClick={()=>selectStory(i)}><span>{item.label}</span><Arrow diagonal /></button>)}
    </div></div>
  </section></Localized>;
}
