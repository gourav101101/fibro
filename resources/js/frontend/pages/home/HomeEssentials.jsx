import { useState } from 'react';
import { Localized } from '@/components/Language/Language';
import MaterialExplorer from '@/components/MaterialExplorer/MaterialExplorer';
import Arrow from '@/components/Arrow/Arrow';
import { materials } from '@/data/company';
import styles from './HomeEssentials.module.css';
import { siteUrl } from '@/utils/siteUrl';

export function MaterialsOverview() {
  const [selected, setSelected] = useState(0);
  return <Localized><section id="technology" className={styles.technology} aria-labelledby="technology-title"><div id="materials" className="container">
    <MaterialExplorer overview={<><p className="eyebrow">Materials & Technology</p><h2 id="technology-title">Three constructions.<br /><span>Made for your application.</span></h2>
      <div className={styles.choices} role="group" aria-label="Choose a material construction">{materials.map((item,index)=><button key={item.id} aria-pressed={selected===index} onClick={()=>setSelected(index)}>{item.name}</button>)}</div>
      <div className={styles.description} aria-live="polite"><p>{materials[selected].details}</p></div>
      <a className="text-link" href={siteUrl("/technology")}>Explore materials & technology <Arrow diagonal /></a>
    </>} />
  </div></section></Localized>;
}

export function ProcessOverview() {
  return <Localized><section id="manufacturing" className={styles.process} aria-labelledby="manufacturing-title"><div className="container">
    <div className={styles.heading}><div><p className="eyebrow">How we work</p><h2 id="manufacturing-title">From first idea<br /><span className="muted-heading">to final fabric.</span></h2></div><a className="text-link" href={siteUrl("/services/custom-development")}>Explore custom development <Arrow diagonal /></a></div>
    <div className={styles.steps}>{[['Understand','Define the feel, function and application.'],['Develop','Sample the right textile, film and adhesive.'],['Refine','Agree the construction and quality criteria.']].map(([title,text])=><div key={title}><h3>{title}</h3><p>{text}</p></div>)}</div>
  </div></section></Localized>;
}

export function AboutOverview() {
  return <Localized><section id="about" className={styles.about} aria-labelledby="about-title"><div className="container">
    <div className={styles.heading}><div><p className="eyebrow">About Fibro</p><h2 id="about-title">Technical textiles.<br /><span className="muted-heading">Personal commitment.</span></h2></div><div className={styles.aboutCopy}><p>Based in Surat, India, Fibro develops coated and laminated textiles around your product. We listen to your requirements, explore materials and refine the construction together.</p><a className="text-link" href={siteUrl("/about")}>Our story, vision & mission <Arrow diagonal /></a></div></div>
    <div className={styles.values}>{[['Integrity','Honest conversations. Clear commitments.'],['Innovation','Explore materials. Develop possibilities.'],['Excellence','Care in the details. Continual refinement.']].map(([title,text])=><div key={title}><h3>{title}</h3><p>{text}</p></div>)}</div>
  </div></section></Localized>;
}
