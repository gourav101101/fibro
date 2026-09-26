import { useState } from 'react';
import Image from '@/components/Image';
import { Localized } from '@/components/Language/Language';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import styles from './ProductPhotos.module.css';

const photos = [
  { colour: 'Blue', image: 'fibro-textile-blue.jpg', swatch: '#80acd6', alt: 'Blue folded textile with a white reverse surface' },
  { colour: 'Coral', image: 'fibro-textile-coral.jpg', swatch: '#e47180', alt: 'Coral folded textile with a white reverse surface' },
  { colour: 'Lilac', image: 'fibro-textile-lilac.jpg', swatch: '#a78aca', alt: 'Lilac folded textile with a white reverse surface' },
];

export default function ProductPhotos() {
  const [selected, setSelected] = useState(0);
  const photo = photos[selected];
  return <Localized><section id="product-photos" className={styles.section} aria-labelledby="product-photos-title">
    <div className="container">
      <p className="eyebrow">Product close-ups</p>
      <h2 id="product-photos-title">Texture. Colour. <span className="muted-heading">Both sides.</span></h2>
      <div className={styles.layout}>
        <div className={styles.photograph}>
          {photos.map((item, index) => <div key={item.image} hidden={index !== selected}><Image src={`/images/${item.image}`} alt={item.alt} fill sizes="(max-width: 800px) 100vw, 60vw" /></div>)}
        </div>
        <div className={styles.copy}>
          <h3>A closer look at our textiles.</h3>
          <p>A textured face. A contrasting reverse. Explore the details in our photographed textile samples.</p>
          <div className={styles.swatches} role="group" aria-label="Textile sample colours">
            {photos.map((item, index) => <button key={item.colour} type="button" aria-label={item.colour} title={item.colour} aria-pressed={selected === index} onClick={() => setSelected(index)}><span style={{ backgroundColor: item.swatch }} /></button>)}
          </div>
          <p className={styles.selection} aria-live="polite">{photo.colour}</p>
          <p className={styles.note}>Discuss colour, construction and sample availability with our team.</p>
          <EnquiryButton context={`Textile sample - ${photo.colour}`}>Request a sample</EnquiryButton>
        </div>
      </div>
    </div>
  </section></Localized>;
}
