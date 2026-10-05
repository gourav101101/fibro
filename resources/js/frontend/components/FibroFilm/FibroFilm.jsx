import { useRef, useState } from 'react';
import { Localized } from '@/components/Language/Language';
import { siteUrl } from '@/utils/siteUrl';
import styles from './FibroFilm.module.css';

export default function FibroFilm() {
  const video = useRef(null);
  const [started, setStarted] = useState(false);

  return <Localized><div className={styles.film}>
    <video
      ref={video}
      controls
      playsInline
      preload="none"
      poster={siteUrl('/video/fibro-film-poster.webp')}
      aria-label="Fibro Laminates film"
      onPlay={() => setStarted(true)}
    >
      <source src={siteUrl('/video/fibro-film.mp4')} type="video/mp4" />
      <a href={siteUrl('/video/fibro-film.mp4')}>Watch the Fibro film</a>
    </video>
    {!started && <button type="button" className={styles.play} onClick={() => video.current?.play()}>
      <span className={styles.icon} aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="m8 5 12 7-12 7z" /></svg></span>
      <span>Watch the Fibro film</span>
    </button>}
  </div></Localized>;
}
