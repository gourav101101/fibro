import { useState } from 'react';
import { Localized } from '@/components/Language/Language';
import Image from '@/components/Image';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import { siteUrl } from '@/utils/siteUrl';
import styles from './PerformanceStories.module.css';
import GRSScope from '@/components/Responsibility/GRSScope';

function ExplainerVideo({ kind, title }) {
  return <Localized><details className={styles.clip}><summary>{title}</summary><video controls playsInline preload="none" poster={siteUrl(`/video/fibro-${kind}-poster.webp`)} aria-label={title}><source src={siteUrl(`/video/fibro-${kind}-explainer.webm`)} type="video/webm" /><a href={siteUrl(`/video/fibro-${kind}-explainer.webm`)}>{title}</a></video><p>Silent animation with English labels. The explanation on this page is available in your selected language.</p></details></Localized>;
}

export function OutdoorPerformance() {
  const [paused, setPaused] = useState(false);
  return <Localized><section className={styles.section} aria-label="Outdoor cover performance">
    <p className="eyebrow">Outdoor furniture covers</p><h2>Protection above. Comfort beneath.</h2>
    <div className={styles.pair}><div className={styles.photo}><Image src="/images/fibro-outdoor-cover.jpg" alt="Grey woven fabric with silver backing" fill sizes="(max-width: 800px) 90vw, 45vw" /></div>
      <div className={`${styles.diagram} ${paused ? styles.paused : ''}`}>
        <svg viewBox="0 0 600 430" role="img" aria-label="Illustration of sunlight reflected above a furniture cover and heat moving outwards">
          <circle cx="90" cy="70" r="30" fill="#e1b64d" />
          {[0,1,2].map(i => <path key={i} className={styles.sunray} style={{animationDelay:`${i * -.7}s`}} d={`M${140+i*95} 75l45 90 50-90m-15 5 15-5-2 17`} fill="none" stroke="#d3a339" strokeWidth="5" />)}
          <path d="M85 295 115 205Q300 140 485 205L515 295" fill="#bfc6c7" stroke="#596d75" strokeWidth="5" />
          <path d="M160 295v-50h280v50M175 295v55m250-55v55" fill="none" stroke="#526472" strokeWidth="12" strokeLinejoin="round" />
          {[0,1,2].map(i => <path key={i} className={styles.heat} style={{animationDelay:`${i * -.8}s`}} d={`M${215+i*80} 280q-18-25 0-50t0-50m-10 12 10-12 10 12`} fill="none" stroke="#b96545" strokeWidth="4" />)}
        </svg>
        <div className={styles.legend}><span>UV protection</span><span>Heat & moisture release</span></div>
        <button type="button" onClick={() => setPaused(!paused)} aria-pressed={paused}>{paused ? 'Play animation' : 'Pause animation'}</button>
      </div></div>
    <p>UV-resistant, breathable cover constructions help manage sunlight exposure and allow heat and moisture to escape. Performance depends on the selected fabric, cover design and ventilation.</p>
    <p>Our outdoor furniture cover range includes recycled polyester fabrics within Fibro’s GRS scope. Ask for the selected construction’s recycled-content details and transaction documentation for your order.</p>
    <a className="text-link" href={siteUrl('/circular-textiles')}>Explore circular textiles</a>
    <p className={styles.note}>Illustrative animation, not a measured performance test.</p>
    <ExplainerVideo kind="outdoor" title="Watch the outdoor cover explainer" />
    <EnquiryButton context="Outdoor furniture covers">Discuss your requirement</EnquiryButton>
  </section></Localized>;
}

export function CircularTextiles({ compact = false }) {
  const [paused, setPaused] = useState(false);
  return <Localized><section className={styles.section} aria-label="Circular textiles">
    <p className="eyebrow">Circular textiles</p><h2>Materials with another chapter.</h2>
    <p>Recycled polyester is currently used in our outdoor furniture cover fabrics. Recycled polyester blackout curtain fabrics are planned for future development.</p>
    <div className={`${styles.loop} ${paused ? styles.paused : ''}`}>
      {['Collect & sort', 'Recover fibres', 'Make fabric', 'Use & care'].map((label,i) => <div className={styles.loopStep} key={label} style={{animationDelay:`${i * 2}s`}}><span>0{i+1}</span><h3>{label}</h3><span aria-hidden="true">→</span></div>)}
    </div>
    <button type="button" onClick={() => setPaused(!paused)} aria-pressed={paused}>{paused ? 'Play animation' : 'Pause animation'}</button>
    <p className={styles.note}>Illustrative circular pathway. Recycling depends on collection, material compatibility and local facilities.</p>
    <ExplainerVideo kind="circular" title="Watch the circular textiles explainer" />
    {!compact && <div className={styles.pair}><article><h3>Recycled inputs</h3><img className={styles.grs} src={siteUrl('/images/credentials/grs.png')} alt="Global Recycled Standard" width="130" height="90" loading="lazy" /><p>Selected products can use recycled fabric. Ask for the recycled-content percentage, applicable GRS scope and transaction documentation for the material you select.</p><a href={siteUrl('/sustainability')}>Environment & Sustainability</a></article><article><h3>Design for recyclability</h3><p>We are exploring recyclable constructions. Material selection, layer compatibility and end-of-life separation must be considered together; recycled content alone does not make a laminate recyclable.</p><EnquiryButton context="Circular textiles">Discuss your requirement</EnquiryButton></article></div>}
    {compact && <a className="text-link" href={siteUrl('/circular-textiles')}>Explore circular textiles</a>}
    {!compact && <GRSScope />}
  </section></Localized>;
}
