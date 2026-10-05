import { Localized } from '@/components/Language/Language';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import Arrow from '@/components/Arrow/Arrow';
import { programmes, responsibilityTopics } from '@/data/responsibility';
import styles from './Responsibility.module.css';
import { siteUrl } from '@/utils/siteUrl';
import { CircularTextiles } from '@/components/PerformanceStories/PerformanceStories';
import Facilities from './Facilities';
import GRSScope, { GRSCertificateLink } from './GRSScope';

export function Credentials({ compact = false }) {
  return <Localized><div className={styles.credentials}>
    <h2>Certifications & industry programmes</h2>
    <div className={styles.logos}>{programmes.map(item => <div className={styles.logoCard} key={item.name}>
      <div className={styles.logoImage}><img src={siteUrl(`/images/credentials/${item.image}`)} alt={item.name} width="180" height="90" loading="lazy" /></div>
      <h3>{item.name}</h3><p>{item.category}</p>
    </div>)}</div>
    {compact ? <div className={styles.certificateAction}><GRSCertificateLink /></div> : <GRSScope />}
    <p className={styles.note}>For current certification scope, audit information or membership details relevant to your enquiry, please contact the Fibro team.</p>
    <a className={styles.membership} href="https://www.ittaindia.org/" target="_blank" rel="noopener noreferrer"><img src={siteUrl('/images/credentials/itta.webp')} alt="Indian Technical Textile Association (ITTA)" width="210" height="140" loading="lazy" /><span>Member — Indian Technical Textile Association (ITTA)</span></a>
  </div></Localized>;
}

export function ResponsibilityHome() {
  return <Localized><section className={styles.home} aria-labelledby="responsibility-title"><div className="container">
    <div className={styles.introduction}><div><p className="eyebrow">Care in every decision</p><h2 id="responsibility-title">Considered materials.<br /><span className="muted-heading">Clear conversations.</span></h2></div>
      <div><p>Explore our processes, discuss your quality requirements and ask about the documentation your sourcing decision needs.</p>
        <div className={styles.links}><a href={siteUrl("/sustainability")}>Environment & Sustainability <Arrow diagonal /></a><a href={siteUrl("/manufacturing-quality")}>Manufacturing & Quality <Arrow diagonal /></a></div>
      </div>
    </div><div className={styles.circularIntro}><h3>Circular textiles</h3><p>Explore recycled polyester inputs and the material choices behind design for recyclability.</p><a className="text-link" href={siteUrl('/circular-textiles')}>Explore circular textiles <Arrow diagonal /></a></div><Credentials compact />
  </div></section></Localized>;
}

export function ResponsibilityContent({ type }) {
  return <Localized><div className={`container ${styles.content}`}>
    <div className={styles.statement}><p className="eyebrow">{type === 'sustainability' ? 'Environment & Sustainability' : 'Manufacturing & Quality'}</p>
      <h2>{type === 'sustainability' ? 'Thoughtful choices, from the start.' : 'The right construction begins with understanding.'}</h2>
      <a href={siteUrl(type === 'sustainability' ? '/services/hot-melt-coating' : '/technology')}>{type === 'sustainability' ? 'Explore hot-melt coating' : 'Explore the technology'} <Arrow diagonal /></a>
    </div>
    <div className={styles.topics}>{responsibilityTopics[type].map(([label,title,text]) => <div className={styles.topic} key={title}><div><p className="eyebrow">{label}</p><h2>{title}</h2></div><p>{text}</p></div>)}</div>
    {type === 'manufacturing-quality' && <Facilities />}
    <Credentials />
    {type === 'sustainability' && <CircularTextiles compact />}
    <div className={styles.enquiry}><div><h2>Bring your requirements.</h2><p>Tell us about the material, quality criteria and documentation your project needs.</p></div><EnquiryButton context={type === 'sustainability' ? 'Sustainability & sourcing' : 'Manufacturing & quality'}>Discuss your requirement</EnquiryButton></div>
    <a className="text-link" href={siteUrl(type === 'sustainability' ? '/manufacturing-quality' : '/sustainability')}>{type === 'sustainability' ? 'Manufacturing & Quality' : 'Environment & Sustainability'} <Arrow diagonal /></a>
  </div></Localized>;
}
