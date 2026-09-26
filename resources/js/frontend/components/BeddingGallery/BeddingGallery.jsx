import { useRef, useState } from 'react';
import Image from '@/components/Image';
import { Localized } from '@/components/Language/Language';
import styles from './BeddingGallery.module.css';

const photos = [
  { file: 'white-bedding', label: 'White bedding', alt: 'White fitted bedding with a blue upholstered headboard' },
  { file: 'white-front', label: 'Front view', alt: 'Front view of white bedding on a wooden bed' },
  { file: 'gold-bedding', label: 'Gold bedding', alt: 'Gold-coloured bedding with matching pillows' },
  { file: 'reverse-detail', label: 'Reverse detail', alt: 'Gold bedding lifted to show its white reverse and the surface underneath' },
  { file: 'fitted-detail', label: 'Fitted detail', alt: 'White bedding lifted at the corner to reveal the mattress underneath' },
  { file: 'bedroom-view', label: 'Bedroom view', alt: 'White bedding shown in a furnished bedroom' },
];

export default function BeddingGallery() {
  const [active, setActive] = useState(0);
  const buttons = useRef([]);
  function navigate(event, index) {
    let next;
    if (event.key === 'ArrowRight') next = (index + 1) % photos.length;
    else if (event.key === 'ArrowLeft') next = (index + photos.length - 1) % photos.length;
    else if (event.key === 'Home') next = 0;
    else if (event.key === 'End') next = photos.length - 1;
    else return;
    event.preventDefault();
    setActive(next);
    buttons.current[next]?.focus();
  }
  return <Localized><div className={styles.gallery} role="group" aria-label="Bedding photographs">
    <div className={styles.stage}>
      {photos.map((photo, index) => <div key={photo.file} hidden={index !== active}><Image src={`/images/products/bedding/${photo.file}.jpg`} alt={photo.alt} fill sizes="(max-width: 850px) 100vw, 55vw" preload={index === 0} /></div>)}
    </div>
    <div className={styles.caption} aria-live="polite"><span>{photos[active].label}</span><span>{active + 1} / {photos.length}</span></div>
    <div className={styles.thumbnails}>
      {photos.map((photo, index) => <button key={photo.file} ref={node => { buttons.current[index] = node; }} type="button" aria-label={photo.label} title={photo.label} aria-pressed={active === index} onClick={() => setActive(index)} onKeyDown={event => navigate(event, index)}><Image src={`/images/products/bedding/${photo.file}.jpg`} alt="" fill sizes="(max-width: 550px) 28vw, 10vw" /></button>)}
    </div>
  </div></Localized>;
}
