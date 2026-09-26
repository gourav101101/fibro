import Arrow from "@/components/Arrow/Arrow";
import { services as servicePages } from "@/data/site";
import { Localized } from '@/components/Language/Language';
import Reveal from '@/components/Reveal/Reveal';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import styles from './CompanySections.module.css';
import { siteUrl } from '@/utils/siteUrl';

export function Capabilities() {
  const services = [
    ['Hot-melt coating', 'A considered starting point.', 'Hot-melt adhesive application without water or solvent carriers.'],
    ['PUR lamination', 'Function through combination.', 'Bring textiles, foams and membranes together in a construction developed around your application.'],
    ['Digital printing', 'Your design, on fabric.', 'Discuss your artwork, fabric and sampling needs.'],
    ['Custom development', 'Your brief comes first.', 'Define the feel, function and care requirements, then develop and refine a suitable material construction.'],
  ];
  return <Localized><section id="services" className={styles.services} aria-labelledby="services-title"><div className="container">
    <Reveal className={styles.heading}><div><p className="eyebrow">What we can do for you</p><h2 id="services-title">Coating, lamination<br /><span className="muted-heading">& digital printing.</span></h2></div><p>Four services, developed around your product.</p></Reveal>
    <div className={styles.servicesGrid}>{services.map(([name,title,text]) => <Reveal key={name} className={styles.service}><h3>{name}</h3><p>{text}</p><a className="text-link" href={siteUrl(`/services/${servicePages.find(item=>item.name===name).slug}`)}>Explore details <Arrow diagonal /></a></Reveal>)}</div>
  </div></section></Localized>;
}

export function AboutFibro({ standalone = false }) {
  const purpose = [
    ['Our vision', 'Possibilities that move products forward.', 'To be a trusted textile development partner, helping buyers turn new ideas into purposeful products.'],
    ['Our mission', 'Understand. Develop. Refine.', 'To connect material knowledge and thoughtful development with each buyer?s needs, through clear communication and care in every construction.'],
  ];
  return <Localized><section id="about" className={styles.about} aria-labelledby="about-title"><div className="container">
    <div className={styles.aboutGrid}><Reveal><p className="eyebrow">The Fibro story</p><h2 id="about-title">Built on trust.<br /><span className="muted-heading">Driven by possibility.</span></h2>
      <p>At Fibro Laminates, our work begins with a conversation: what does your product need to do?</p>
      <p>Based in Surat, India, we bring together textile knowledge, coating, lamination and digital printing to explore the answer. From a luggage fabric to a protective cover, each brief calls for its own balance of feel, function and finish.</p>
      <p>We listen, develop and refine with that purpose in mind. Our aim is a material you understand, and a partnership you can trust.</p>
      {standalone ? <EnquiryButton>Talk to the Fibro team</EnquiryButton> : <a className="text-link" href={siteUrl("/about")}>Get to know Fibro <Arrow diagonal /></a>}
    </Reveal><div className={styles.direction}>{purpose.map(([label,title,text]) => standalone
      ? <Reveal key={label}><p className="eyebrow">{label}</p><h3>{title}</h3><p>{text}</p></Reveal>
      : <details key={label} name="fibro-purpose" className={styles.purpose}><summary><span className="eyebrow">{label}</span><span className={styles.purposeTitle}>{title}</span><span className={styles.plus} aria-hidden="true">+</span></summary><p>{text}</p></details>
    )}</div></div>
    <div className={styles.valuesHeading}><p className="eyebrow">Our values</p><p>Three principles. One way of working.</p></div>
    <div className={styles.values}>{[
      ['Integrity', 'Build trust through honest conversations, clear commitments and respect for our partners.'],
      ['Innovation', 'Stay curious. Explore materials, processes and ideas that can better serve the product.'],
      ['Excellence', 'Pay attention to the details, refine our work and keep raising our standards.'],
    ].map(([name,text])=><Reveal key={name}><h3>{name}</h3><p>{text}</p></Reveal>)}</div>
  </div></section></Localized>;
}
