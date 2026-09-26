import { Localized } from '@/components/Language/Language';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import Arrow from '@/components/Arrow/Arrow';
import { programmes, responsibilityTopics } from '@/data/responsibility';
import styles from './Responsibility.module.css';
import { siteUrl } from '@/utils/siteUrl';

export function Credentials() {
  return <Localized><div className={styles.credentials}>
    <h2>Certifications & industry programmes</h2>
    <div className={styles.logos}>{programmes.map(item => <div className={styles.logoCard} key={item.name}>
      <div className={styles.logoImage}><img src={siteUrl(`/images/credentials/${item.image}`)} alt={item.name} width="180" height="90" loading="lazy" /></div>
      <h3>{item.name}</h3><p>{item.category}</p>
    </div>)}</div>
    <p className={styles.note}>For current certification scope, audit information or membership details relevant to your enquiry, please contact the Fibro team.</p>
  </div></Localized>;
}

export function ResponsibilityHome() {
  return <Localized><section className={styles.home} aria-labelledby="responsibility-title"><div className="container">
    <div className={styles.introduction}><div><p className="eyebrow">Care in every decision</p><h2 id="responsibility-title">Considered materials.<br /><span className="muted-heading">Clear conversations.</span></h2></div>
      <div><p>Explore our processes, discuss your quality requirements and ask about the documentation your sourcing decision needs.</p>
        <div className={styles.links}><a href={siteUrl("/sustainability")}>Environment & Sustainability <Arrow diagonal /></a><a href={siteUrl("/manufacturing-quality")}>Manufacturing & Quality <Arrow diagonal /></a></div>
      </div>
    </div><Credentials />
  </div></section></Localized>;
}

export function ResponsibilityContent({ type }) {
  return <Localized><div className={`container ${styles.content}`}>
    <div className={styles.statement}><p className="eyebrow">{type === 'sustainability' ? 'Environment & Sustainability' : 'Manufacturing & Quality'}</p>
      <h2>{type === 'sustainability' ? 'Thoughtful choices, from the start.' : 'The right construction begins with understanding.'}</h2>
      <a href={siteUrl(type === 'sustainability' ? '/services/hot-melt-coating' : '/technology')}>{type === 'sustainability' ? 'Explore hot-melt coating' : 'Explore the technology'} <Arrow diagonal /></a>
    </div>
    <div className={styles.topics}>{responsibilityTopics[type].map(([label,title,text]) => <div className={styles.topic} key={title}><div><p className="eyebrow">{label}</p><h2>{title}</h2></div><p>{text}</p></div>)}</div>
    <Credentials />
    <div className={styles.enquiry}><div><h2>Bring your requirements.</h2><p>Tell us about the material, quality criteria and documentation your project needs.</p></div><EnquiryButton context={type === 'sustainability' ? 'Sustainability & sourcing' : 'Manufacturing & quality'}>Discuss your requirement</EnquiryButton></div>
    <a className="text-link" href={siteUrl(type === 'sustainability' ? '/manufacturing-quality' : '/sustainability')}>{type === 'sustainability' ? 'Manufacturing & Quality' : 'Environment & Sustainability'} <Arrow diagonal /></a>
  </div></Localized>;
}
