import { Localized } from '@/components/Language/Language';
import Image from '@/components/Image';
import styles from './Responsibility.module.css';

const facilities = [
  ['lamination', 'Coating & lamination', 'Roll-to-roll machinery at Fibro', 'PUR hot-melt and multipurpose lamination bring textiles, foams and membranes together.'],
  ['inspection', 'Raw material inspection', 'Illuminated fabric inspection machine at Fibro', 'Roll-to-roll inspection checks the incoming fabric before lamination.'],
  ['laboratory', 'In-house quality laboratory', 'Fabric testing instruments in the Fibro laboratory', 'Testing facilities include fabric weight and thickness, tear and tensile strength, water repellency, colour fastness, abrasion and pilling.'],
  ['stitching', 'Cutting & stitching', 'Fibro team working at industrial sewing machines', 'In-house cutting and stitching support made-up products, including mattress protectors, pillow covers and baby underlays.'],
];

export default function Facilities() {
  return <Localized><section className={styles.facilities} aria-labelledby="facilities-title">
    <p className="eyebrow">Inside Fibro</p><h2 id="facilities-title">From the factory floor to the quality laboratory.</h2>
    <div className={styles.facilityGrid}>{facilities.map(([image,title,alt,text]) => <article key={image}>
      <div className={styles.facilityImage}><Image src={`/images/facilities/${image}.png`} alt={alt} fill sizes="(max-width: 700px) 90vw, 45vw" /></div>
      <h3>{title}</h3><p>{text}</p>
    </article>)}</div>
  </section></Localized>;
}
