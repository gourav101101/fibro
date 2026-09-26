"use client";
import { Localized } from "@/components/Language/Language";
import { useEffect, useRef, useState, useSyncExternalStore } from "react";
import styles from "./MaterialExplorer.module.css";

const layers = [
  { name: "Face textile", purpose: "The first point of contact.", description: "The outer fabric defines the surface, texture and appearance. Select it around the feel and durability your product needs." },
  { name: "Functional membrane", purpose: "Performance, beneath the surface.", description: "A selected film introduces the required barrier properties. Breathability and protection depend on the membrane and the complete construction." },
  { name: "Backing textile", purpose: "The finishing touch.", description: "The inner textile supports the construction and influences comfort against the body or the product it protects." },
];

function subscribeMotion(callback) {
  const query = window.matchMedia('(prefers-reduced-motion: reduce)');
  query.addEventListener('change', callback);
  return () => query.removeEventListener('change', callback);
}
const reducedMotionSnapshot = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export default function MaterialExplorer({ overview }) {
  const [active, setActive] = useState(0);
  const [separated, setSeparated] = useState(true);
  const [playing, setPlaying] = useState(true);
  const [visible, setVisible] = useState(false);
  const visual = useRef(null);
  const step = useRef(0);
  const reducedMotion = useSyncExternalStore(subscribeMotion, reducedMotionSnapshot, () => true);
  const running = playing && !reducedMotion;

  useEffect(() => {
    const observer = new IntersectionObserver(([entry]) => setVisible(entry.isIntersecting), { threshold: 0.4 });
    observer.observe(visual.current);
    return () => observer.disconnect();
  }, []);

  useEffect(() => {
    if (!running || !visible) return;
    const timer = window.setInterval(() => {
      if (document.hidden) return;
      step.current += 1;
      if (step.current < 3) setActive(step.current);
      else {
        setSeparated(false);
        setPlaying(false);
      }
    }, 2400);
    return () => window.clearInterval(timer);
  }, [running, visible]);

  function selectLayer(index) {
    setPlaying(false);
    setActive(index);
    setSeparated(true);
  }

  function replay() {
    step.current = 0;
    setActive(0);
    setSeparated(true);
    setPlaying(true);
  }
  return (
    <Localized><div className={styles.grid}>
      <div className={styles.copy}>{overview || <>
        <p className="eyebrow">Lamination technology</p>
        <h2 id="technology-title">The difference is<br /><span>between the layers.</span></h2>
        <p className={styles.intro}>Each layer has a role. PUR adhesive bonding brings them together into one purposeful material.</p>
        <div className={styles.layerList} aria-label="Explore the material layers">
          {layers.map((layer, i) => <div key={layer.name} className={active === i ? styles.activeItem : ""}>
            <button type="button" aria-expanded={active === i} aria-controls={`layer-description-${i}`} onClick={() => selectLayer(i)}><span>0{i + 1}</span>{layer.name}<span aria-hidden="true">{active === i ? "−" : "+"}</span></button>
            <div id={`layer-description-${i}`} hidden={active !== i}><p>{layer.description}</p></div>
          </div>)}
        </div>
      </>}</div>
      <div ref={visual} className={styles.visual}>
        <div className={styles.diagramHeading}><span>{overview ? "Membrane construction example" : "ANATOMY OF A LAMINATE"}</span>{!reducedMotion && <button className={styles.playback} type="button" onClick={running ? () => setPlaying(false) : replay} aria-label={running ? "Pause animation" : "Replay animation"} title={running ? "Pause animation" : "Replay animation"}><span aria-hidden="true">{running ? "\u23f8" : "\u21bb"}</span></button>}</div>
        <svg className={styles.diagram} viewBox="0 0 610 530" role="img" aria-label={`Illustrative three-layer laminate, ${separated ? "separated" : "bonded"}. Highlighted: ${layers[active].name}.`}>
          <defs>
            <pattern id="fibro-weave" width="8" height="8" patternUnits="userSpaceOnUse" patternTransform="rotate(-18)"><path d="M0 0h8v8H0Z" fill="#61717b" /><path d="M0 2h8M2 0v8" stroke="#aeb9bb" strokeWidth="1" opacity=".6" /><path d="M0 6h8M6 0v8" stroke="#30424d" strokeWidth="2" /></pattern>
            <pattern id="fibro-backing" width="5" height="5" patternUnits="userSpaceOnUse"><path d="M0 0h5v5H0Z" fill="#637579" /><path d="M0 1h5M1 0v5" stroke="#a9b1ad" strokeWidth=".6" /></pattern>
            <linearGradient id="fibro-film" x1="0" y1="0" x2="1" y2="1"><stop stopColor="#b8c7e0" /><stop offset=".55" stopColor="#6d84ae" /><stop offset="1" stopColor="#d5deed" /></linearGradient>
          </defs>
          <g className={styles.construction} style={{ transform: separated ? "translateY(0)" : "translateY(100px)" }}>
            {[2, 1, 0].map(i => <g key={i} className={`${styles.sheet} ${active === i ? styles.selectedSheet : ""}`} style={{ transform: `translateY(${i * (separated ? 100 : 13)}px)` }}>
              <path d="M65 147 293 57 533 163 305 258Z" fill={["url(#fibro-weave)", "url(#fibro-film)", "url(#fibro-backing)"][i]} stroke={active === i ? "#becbe5" : "#8b969a"} strokeWidth={active === i ? "2" : "1"} />
              <path d="m65 147 240 111 228-95v8L305 266 65 155Z" fill={i === 1 ? "#566d96" : "#34454e"} stroke="#8b969a" strokeWidth=".5" />
              <path d="m91 149 202-80 214 94-202 83Z" fill="none" stroke="#ffffff50" strokeDasharray="3 5" />
              <circle cx="305" cy="260" r="13" fill={active === i ? "#becbe5" : "#16283a"} stroke="#9aaed3" />
              <text x="305" y="264" textAnchor="middle" fill={active === i ? "#0c1829" : "#d6d9d6"} fontSize="10">0{i + 1}</text>
            </g>)}
          </g>
        </svg>
        <div className={styles.stages} role="group" aria-label="Explore the material layers">{layers.map((layer, i) => <button key={layer.name} type="button" aria-pressed={active === i && separated} onClick={() => selectLayer(i)}><span aria-hidden="true">0{i + 1}</span>{layer.name}</button>)}</div>
        <div className={styles.diagramControls}><p aria-live={running ? "off" : "polite"}><span>{separated ? <>0{active + 1} / {layers[active].name}</> : "PUR adhesive bonding"}</span>{separated ? layers[active].purpose : "One purposeful material."}</p><button type="button" aria-pressed={!separated} onClick={() => { setPlaying(false); setSeparated(!separated); }}>{separated ? "Bring layers together" : "Separate the layers"}<span aria-hidden="true">{separated ? "↓" : "↑"}</span></button></div>
        <p className={styles.caption}>Illustrative three-layer construction. Materials and bonding are selected for each application.</p>
      </div>
    </div></Localized>
  );
}
