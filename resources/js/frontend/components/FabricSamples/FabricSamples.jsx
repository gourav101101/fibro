import { useId } from 'react';
import Image from '@/components/Image';
import { Localized } from '@/components/Language/Language';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import styles from './FabricSamples.module.css';

const samples = [
  { name: 'Baby cloth diaper fabrics', slug: 'baby-cloth-fabrics', photos: [
    ['fibro-diaper-watermelon.jpg', 'Watermelon print with reverse side'],
    ['fibro-diaper-rabbits.jpg', 'Yellow rabbit print with reverse side'],
    ['fibro-diaper-rainbows.jpg', 'Rainbow print with white reverse side'],
    ['fibro-diaper-elephants.jpg', 'Elephant print with reverse side'],
  ] },
  { name: 'Period panty liner fabrics', slug: 'reusable-sanitary-pad-fabrics', photos: [['fibro-period-panty-liner.jpg', 'Grey fabric with silver reverse side']] },
  { name: 'Blackout curtain fabrics', slug: 'blackout-curtains', photos: [['fibro-blackout-curtain.jpg', 'Light curtain fabric with dark backing']] },
  { name: 'Outdoor furniture cover fabrics', slug: 'outdoor-furniture-covers', photos: [['fibro-outdoor-cover.jpg', 'Grey woven fabric with silver backing']], note: 'Discuss UV fastness and breathability requirements for your cover.' },
];

export default function FabricSamples({ productSlug, contained = false }) {
  const titleId = useId();
  const visible = productSlug ? samples.filter(sample => sample.slug === productSlug) : samples;
  if (!visible.length) return null;
  return <Localized><section className={styles.section} aria-labelledby={titleId}>
    <div className={contained ? undefined : 'container'}>
      <p className="eyebrow">Fabric samples</p>
      <h2 id={titleId}>{visible[0].name}</h2>
      <p className={styles.intro}>Explore our photographed samples and discuss the right construction for your product.</p>
      <div className={`${styles.grid} ${productSlug ? styles.single : ''}`}>
        {visible.map(sample => <article key={sample.slug} className={styles.card}>
          <div className={sample.photos.length > 1 ? styles.multiple : styles.photos}>
            {sample.photos.map(([file, alt]) => <div className={styles.photo} key={file}><Image src={`/images/${file}`} alt={alt} fill sizes={sample.photos.length > 1 ? '(max-width: 700px) 45vw, 23vw' : '(max-width: 700px) 90vw, 46vw'} /></div>)}
          </div>
          <div className={styles.copy}>{sample.note && <p>{sample.note}</p>}<EnquiryButton context={sample.name}>Request a sample</EnquiryButton></div>
        </article>)}
      </div>
    </div>
  </section></Localized>;
}
