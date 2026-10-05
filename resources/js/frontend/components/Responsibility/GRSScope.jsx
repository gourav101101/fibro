import { Localized } from '@/components/Language/Language';
import { siteUrl } from '@/utils/siteUrl';
import styles from './Responsibility.module.css';

export function GRSCertificateLink() {
  return <Localized><a className={styles.certificateButton} href={siteUrl('/documents/fibro-grs-scope-certificate.pdf')} target="_blank" rel="noopener noreferrer">
    <svg width="24" height="28" viewBox="0 0 24 28" fill="none" aria-hidden="true"><path d="M5 2h9l5 5v19H5V2Z M14 2v6h5 M8 14h8 M8 18h8 M8 22h5" stroke="currentColor" strokeWidth="1.6" strokeLinejoin="round" /></svg>
    <span>View full GRS certificate (PDF, 3 pages)</span><span aria-hidden="true">↗</span>
  </a></Localized>;
}

export default function GRSScope() {
  return <Localized><div className={styles.scope}>
    <h3>GRS scope certificate</h3>
    <p>Fibro’s facility is audited under GRS for the recycled polyester fabric constructions and processes listed in its scope certificate. Our current application is outdoor furniture cover fabrics; recycled polyester blackout curtain fabrics are planned for future development.</p>
    <p>Intertek issued Fibro Laminates Private Limited’s GRS 4.0 scope certificate on 21 August 2026, with an expiry date of 20 August 2027.</p>
    <p className={styles.identifier}>ITS-TE-00350005-GRS-0001467 · TE-00350005</p>
    <p>The scope lists special fabrics with a 100% post-consumer recycled polyester base fabric or base knitted fabric, laminated with TPU. The 100% figure describes the polyester base component, not the complete laminate.</p>
    <p>Covered processes include finishing, trading, and warehousing and distribution of non-final products. Certification of a particular delivery requires a valid transaction certificate or equivalent.</p>
    <GRSCertificateLink />
  </div></Localized>;
}
