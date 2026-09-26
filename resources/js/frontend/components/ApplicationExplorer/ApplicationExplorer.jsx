"use client";
import { Localized } from "@/components/Language/Language";
import { useRef, useState } from "react";
import Image from "@/components/Image";
import Arrow from "@/components/Arrow/Arrow";
import styles from "./ApplicationExplorer.module.css";
import { siteUrl } from "@/utils/siteUrl";
import { products as applications } from "@/data/site";



export default function ApplicationExplorer() {
  const [active, setActive] = useState(0);
  const tabs = useRef([]);
  function navigate(event, index) {
    let next;
    if (event.key === "ArrowRight") next = (index + 1) % applications.length;
    else if (event.key === "ArrowLeft") next = (index + applications.length - 1) % applications.length;
    else if (event.key === "Home") next = 0;
    else if (event.key === "End") next = applications.length - 1;
    else return;
    event.preventDefault();
    setActive(next);
    tabs.current[next]?.focus();
  }
  return <Localized><div>
    <div role="tablist" aria-label="Textile applications" className={styles.tabs}>
      {applications.map((app,i) => <button key={app.name} ref={el => { tabs.current[i] = el; }} type="button" role="tab" id={`application-tab-${i}`} aria-controls={`application-panel-${i}`} aria-selected={active === i} tabIndex={active === i ? 0 : -1} onClick={() => setActive(i)} onKeyDown={e => navigate(e,i)}>{app.name}<Arrow diagonal /></button>)}
    </div>
    {applications.map((app,i) => <div key={app.name} role="tabpanel" id={`application-panel-${i}`} aria-labelledby={`application-tab-${i}`} hidden={active !== i} tabIndex={0} className={styles.panel}>
      <div className={styles.image}><Image src={`/images/${app.image}`} alt={app.alt} fill sizes="(max-width: 800px) 100vw, 60vw" /><span>APPLICATION STUDY</span></div>
      <div className={styles.copy}><span className={styles.category}>{app.name.toUpperCase()}</span><h3>{app.title}</h3><p>{app.text}</p><div className={styles.material}>{app.material}</div><a className="text-link" href={siteUrl(`/products/${app.slug}`)}>Explore details <Arrow diagonal /></a></div>
    </div>)}
  </div></Localized>;
}
