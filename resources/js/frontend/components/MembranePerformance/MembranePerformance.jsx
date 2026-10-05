import { useState } from 'react';
import { Localized } from '@/components/Language/Language';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import Reveal from '@/components/Reveal/Reveal';
import styles from './MembranePerformance.module.css';

const features = [
  { name: 'Rain protection', title: 'A barrier to the elements.', text: 'A hydrophilic TPU membrane can provide a barrier to liquid water within a carefully selected fabric construction.', label: 'Liquid water stays outside' },
  { name: 'Moisture transfer', title: 'A way out for moisture.', text: 'Hydrophilic membranes absorb and transport moisture through the film, releasing it towards the outside when conditions allow.', label: 'Moisture moves through the membrane' },
  { name: 'Everyday comfort', title: 'Performance you can feel.', text: 'Combine a soft textile with a functional membrane for sportswear and outdoor apparel, balancing protection, moisture transfer and feel.', label: 'Developed around movement and comfort' },
];

function JacketComparison() {
  return <Localized><div className={styles.jacketComparison}>
    <svg className={styles.jacketDiagram} viewBox="0 0 660 350" role="img" aria-label="Illustrative comparison: moisture escapes from uncovered skin, can build up inside a less breathable jacket, and can move outward through a hydrophilic membrane jacket.">
      <defs>
        <linearGradient id="jacket-shell" x1="0" y1="0" x2="1" y2="1"><stop stopColor="#58788b"/><stop offset=".5" stopColor="#2e4f65"/><stop offset="1" stopColor="#1b354b"/></linearGradient>
        <linearGradient id="jacket-skin" x1="0" y1="0" x2="1" y2="1"><stop stopColor="#dae2e6"/><stop offset="1" stopColor="#8d9eac"/></linearGradient>
        <radialGradient id="jacket-warmth"><stop stopColor="#e3a176" stopOpacity=".65"/><stop offset="1" stopColor="#e3a176" stopOpacity="0"/></radialGradient>
      </defs>
      {[0,1,2].map(index => <g key={index} transform={`translate(${index * 220},0)`}>
        <ellipse cx="110" cy="324" rx="78" ry="9" fill="#0a192b" opacity=".25"/>
        <path d="M91 84v22l-38 15q-12 5-16 26L19 282l29 6 22-100-3 128h86l-3-128 22 100 29-6-18-135q-4-21-16-26l-38-15V84" fill="url(#jacket-skin)" stroke="#b5c6d1" strokeWidth="1.5"/>
        <path d="M88 51q0-27 22-27t22 27v24q-3 24-22 25-19-1-22-25Z" fill="url(#jacket-skin)" stroke="#b5c6d1" strokeWidth="1.5"/>
        <path d="m93 61 8-2m18 0 8 2m-18 3-3 12 8 1m-12 10q8 4 15 0" stroke="#657f91" strokeWidth="1.3" fill="none"/>
        {index > 0 && <g>
          <path d="m88 101-34 15q-15 6-19 24L14 284l34 8 23-106-7 132h92l-7-132 23 106 34-8-21-144q-4-18-19-24l-34-15-22 15Z" fill="url(#jacket-shell)" stroke={index === 2 ? '#9dd3cc' : '#99adbc'} strokeWidth="1.8"/>
          <path d="m88 101 22 15-12 23-16-28m50-10-22 15 12 23 16-28M110 117v197M73 141l-9 32m83-32 9 32M80 237l-5 32m65-32 5 32M18 272l32 7m120 0 32-7M66 307h88" stroke="#a3bac8" strokeWidth="1.4" fill="none"/>
          <path d="M114 147v12" stroke="#d9e4e9" strokeWidth="3"/>
          <path d="M133 157h12v9h-12Z" fill={index === 2 ? '#9dd3cc' : '#869dad'}/>
        </g>}
        {index === 1 && <ellipse className={styles.heat} cx="110" cy="224" rx="46" ry="86" fill="url(#jacket-warmth)"/>}
        {[170,215,260].map((y,i) => <g key={y} fill="none" stroke={index === 1 ? '#edb28a' : '#a7ddd5'} strokeWidth="2" strokeLinecap="round">
          {index === 1 ? <>
            <path className={styles.trappedFlow} style={{ '--delay': `${i * -.6}s` }} d={`M88 ${y+15}q-12-12 0-23t0-23M132 ${y+15}q12-12 0-23t0-23`} strokeDasharray="3 7"/>
          </> : <>
            <path className={styles.outwardFlow} style={{ '--delay': `${i * -.6}s` }} d={`M83 ${y}q-20-12-33 0t-33 0M137 ${y}q20-12 33 0t33 0`} strokeDasharray="4 7"/>
            <path d={`m24 ${y-6}-7 6 7 6m172-12 7 6-7 6`}/>
          </>}
        </g>)}
      </g>)}
    </svg>
    <div className={styles.jacketLabels}>
      <div><span>01 /</span><h3>No jacket</h3><p>Natural evaporation</p></div>
      <div><span>02 /</span><h3>Less breathable jacket</h3><p>Moisture can build up</p></div>
      <div><span>03 /</span><h3>Membrane jacket</h3><p>Moisture can move out</p></div>
    </div>
    <p className={styles.jacketNote}>Illustrative garment comparison, not a measured performance test.</p>
  </div></Localized>;
}

export default function MembranePerformance() {
  const [active, setActive] = useState(1);
  const [paused, setPaused] = useState(false);
  const [view, setView] = useState('jacket');
  return <Localized><section id="membrane-performance" className={`section ${styles.section}`} aria-labelledby="membrane-title">
    <div className="container">
      <Reveal className={styles.heading}><div><p className="eyebrow">Hydrophilic membrane technology</p><h2 id="membrane-title">Rain outside.<br className={styles.headingBreak} />{' '}<span className="muted-heading">Comfort inside.</span></h2></div><p>A quiet layer of innovation.<br />Explore how a functional membrane brings protection and moisture management together.</p></Reveal>
      <div className={styles.grid}>
        <div className={styles.visual} data-feature={active} data-paused={paused}>
          <div className={styles.viewChoices} role="group" aria-label="Choose a technology illustration">
            <button type="button" aria-pressed={view === 'jacket'} onClick={() => setView('jacket')}>On the body</button>
            <button type="button" aria-pressed={view === 'fabric'} onClick={() => setView('fabric')}>Inside the fabric</button>
          </div>
          <div className={styles.visualTop}><span>{view === 'jacket' ? 'Comfort in motion' : 'Inside the fabric'}</span><button type="button" onClick={() => setPaused(!paused)} aria-pressed={paused}>{paused ? 'Play animation' : 'Pause animation'}<span aria-hidden="true">{paused ? '▷' : 'Ⅱ'}</span></button></div>
          {view === 'jacket' ? <JacketComparison /> : <>
          <div className={styles.environment}><span>Outer environment</span><span>Rain & exposure</span></div>
          <svg className={styles.diagram} viewBox="0 0 660 350" role="img" aria-label="Illustrative fabric cross-section: rain remains above the outer textile while moisture travels out through the membrane from below.">
            <defs>
              <linearGradient id="membrane-face" x2="0" y2="1"><stop stopColor="#b9c9d8"/><stop offset="1" stopColor="#758b9f"/></linearGradient>
              <linearGradient id="membrane-core"><stop stopColor="#8cc8c8"/><stop offset=".5" stopColor="#dbefde"/><stop offset="1" stopColor="#8cc8c8"/></linearGradient>
              <pattern id="membrane-knit" width="9" height="7" patternUnits="userSpaceOnUse"><path d="m0 0 4.5 7L9 0M0 3.5h9" fill="none" stroke="#e5edf3" strokeWidth=".7" opacity=".5"/></pattern>
            </defs>
            <g className={styles.rain} fill="#a9cfed">{[110,220,330,440,550].map((x,i) => <path key={x} className={styles.drop} style={{ '--delay': `${i * -.65}s` }} d={`M${x} 43c-3 7-9 13-9 19a9 9 0 0 0 18 0c0-6-6-12-9-19Z`}/>)}</g>
            <g className={styles.fabric}>
              <path d="m48 131 30-20h535l-30 20Z" fill="#d1dce5"/>
              <path d="M48 131h535v44H48Z" fill="url(#membrane-face)"/>
              <path d="M48 131h535v44H48Z" fill="url(#membrane-knit)"/>
              <path d="m583 131 30-20v44l-30 20Z" fill="#647c90"/>
              <path className={styles.core} d="M48 185h535v20H48Z" fill="url(#membrane-core)"/>
              <path d="m583 185 30-20v20l-30 20Z" fill="#6ba4a8"/>
              <path d="M48 216h535v36H48Z" fill="#8a9295"/>
              <path d="M48 216h535v36H48Z" fill="url(#membrane-knit)"/>
              <path d="m583 216 30-20v36l-30 20Z" fill="#606e76"/>
            </g>
            <g className={styles.vapour} fill="none" stroke="#e0c891" strokeWidth="2.5" strokeLinecap="round">{[160,275,390,505].map((x,i) => <g key={x}>
              <path className={styles.flow} style={{ '--delay': `${i * -.7}s` }} d={`M${x} 319c-25-35 25-49 0-83s25-49 0-83 25-49 0-72`} strokeDasharray="5 12"/>
              <path d={`m${x-6} 91 6-10 6 10`}/>
            </g>)}</g>
          </svg>
          <div className={styles.environment}><span>Next to the body</span><span>Warmth & moisture</span></div>
          <div className={styles.legend}><span><i/>Outer textile</span><span><i/>Hydrophilic membrane</span><span><i/>Inner textile</span></div>
          <p className={styles.visualCaption} aria-live="polite">{features[active].label}</p>
          </>}
        </div>
        <div className={styles.copy}>
          <p className={styles.prompt}>Explore the performance</p>
          <div className={styles.features}>{features.map((feature,i) => <div key={feature.name} className={active === i ? styles.selected : ''}>
            <button type="button" aria-expanded={active === i} aria-controls={`membrane-detail-${i}`} onClick={() => setActive(i)}><span className={styles.number}>0{i+1}</span><span>{feature.name}</span><span className={styles.plus} aria-hidden="true">{active === i ? '−' : '+'}</span></button>
            <div id={`membrane-detail-${i}`} hidden={active !== i}><h3>{feature.title}</h3><p>{feature.text}</p></div>
          </div>)}</div>
          <div className={styles.enquiry}><EnquiryButton context="Hydrophilic membrane technology">Develop your fabric with us</EnquiryButton></div>
          <p className={styles.note}>Illustrative mechanism. Protection and moisture transfer depend on the membrane, fabric construction and conditions of use. Discuss testing for your application.</p>
        </div>
      </div>
    </div>
  </section></Localized>;
}
