import { ResponsibilityHome } from '@/components/Responsibility/Responsibility';
import { Capabilities, AboutFibro } from "@/components/CompanySections/CompanySections";

import Image from '@/components/Image';
import MaterialExplorer from '@/components/MaterialExplorer/MaterialExplorer';
import ProductPhotos from '@/components/ProductPhotos/ProductPhotos';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import { materials } from '@/data/company';
import { Localized } from "@/components/Language/Language";
import Header from "@/components/Header/Header";
import HeroStory from "@/components/HeroStory/HeroStory";
import Footer from "@/components/Footer/Footer";
import ApplicationExplorer from "@/components/ApplicationExplorer/ApplicationExplorer";
import Reveal from "@/components/Reveal/Reveal";
import styles from "./page.module.css";
import WhatsApp from "@/components/WhatsApp/WhatsApp";
import MembranePerformance from '@/components/MembranePerformance/MembranePerformance';
import { siteUrl } from '@/utils/siteUrl';



export default function HomePage() {
  return (
    <Localized><>
      <Header />
      <main id="main-content" tabIndex={-1}>
        <HeroStory />
        <section id="applications" className={`section ${styles.applications}`} aria-labelledby="applications-title">
          <div className="container">
            <Reveal className={styles.sectionHeading}><div><p className="eyebrow">Find your application</p><h2 id="applications-title">Fabrics for <span className="muted-heading">your product.</span></h2></div><p className={styles.headingAside}>Explore the range. Choose a category to see how we can support your product.</p></Reveal>
            <ApplicationExplorer />
          </div>
        </section>
        <Capabilities />
        <section id="materials" className={`section ${styles.materials}`} aria-labelledby="materials-title">
          <div className="container">
            <Reveal className={styles.sectionHeading}>
              <div><p className="eyebrow">Our materials</p><h2 id="materials-title">Materials. <span className="muted-heading">Made for more.</span></h2></div>
              <p className={styles.headingAside}>Three ways to bring materials together. One construction developed around your product.</p>
            </Reveal>
            <div className={styles.materialGrid}>
              {materials.map((material, index) => <Reveal key={material.id} className={`${styles.materialCard} ${index === 0 ? styles.featuredMaterial : ''}`}>
                <div className={styles.materialImage}><Image src={material.image} alt={material.alt} fill sizes="(max-width: 850px) 100vw, 33vw" /><span className={styles.materialUse}>{material.use}</span></div>
                <p className={styles.materialCategory}>{material.category}</p><h3>{material.name}</h3><p className={styles.materialDescription}>{material.description}</p>
                <details name="fibro-material-details" className={styles.materialDetails}><summary>Material details <span aria-hidden="true">+</span></summary><div><p>{material.details}</p><p className={styles.attributes}>{material.attributes}</p><EnquiryButton context={material.name}>Enquire about this material</EnquiryButton></div></details>
              </Reveal>)}
            </div>
          </div>
        </section>
        <ProductPhotos />
        <section id="technology" className={styles.technology} aria-labelledby="technology-title"><div className="container"><MaterialExplorer homepage /></div></section>
        <MembranePerformance />
        <section id="manufacturing" className={`section ${styles.manufacturing}`} aria-labelledby="manufacturing-title">
          <div className={`container ${styles.manufacturingGrid}`}>
            <Reveal className={styles.factoryVisual}><Image src="/images/facilities/lamination.png" alt="Roll-to-roll machinery at Fibro" fill sizes="(max-width: 850px) 90vw, 50vw" /></Reveal>
            <Reveal className={styles.manufacturingCopy}>
              <p className="eyebrow">The craft behind the material</p><h2 id="manufacturing-title">From first idea<br /><span className="muted-heading">to final fabric.</span></h2>
              <p>From your brief to a custom construction: textile knowledge, hot-melt coating and PUR lamination.</p>
              <div className={styles.processList}>{[['Understand','Define the feel, function and application.'],['Develop','Sample the right textile, film and adhesive.'],['Refine','Agree the construction and quality criteria.']].map(([title,text],i)=><div key={title}><span>0{i+1}</span><div><h3>{title}</h3><p>{text}</p></div></div>)}</div>
              <EnquiryButton>Build something with us</EnquiryButton>
              <a className="text-link" href={siteUrl('/manufacturing-quality')}>Explore our factory & laboratory</a>
            </Reveal>
          </div>
        </section>
        <AboutFibro />
        <ResponsibilityHome />
      </main>
      <Footer />
      <WhatsApp compact />
    </></Localized>
  );
}
