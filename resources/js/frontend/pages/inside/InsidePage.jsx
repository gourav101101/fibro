import { ResponsibilityContent } from '@/components/Responsibility/Responsibility';
import { Localized } from '@/components/Language/Language';
import Header from '@/components/Header/Header';
import Footer from '@/components/Footer/Footer';
import WhatsApp from '@/components/WhatsApp/WhatsApp';
import Image from '@/components/Image';
import Arrow from '@/components/Arrow/Arrow';
import EnquiryButton from '@/components/EnquiryButton/EnquiryButton';
import EnquiryForm from '@/components/EnquiryButton/EnquiryForm';
import { AboutFibro } from '@/components/CompanySections/CompanySections';
import MaterialExplorer from '@/components/MaterialExplorer/MaterialExplorer';
import BeddingGallery from '@/components/BeddingGallery/BeddingGallery';
import FabricSamples from '@/components/FabricSamples/FabricSamples';
import { CircularTextiles, OutdoorPerformance } from '@/components/PerformanceStories/PerformanceStories';
import { company, materials } from '@/data/company';
import { products, services } from '@/data/site';
import styles from './InsidePage.module.css';
import { siteUrl } from '@/utils/siteUrl';

function Cards({ items, base }) {
  return <Localized><div className={styles.cards}>{items.map(item=><a key={item.slug} href={siteUrl(`${base}/${item.slug}`)} className={styles.card}>
    <div className={styles.cardImage}><Image src={`/images/${item.image}`} alt={item.alt || 'Illustrative textile material study'} fill sizes="(max-width: 650px) 100vw, (max-width: 1050px) 50vw, 33vw" /></div>
    <div className={styles.cardCopy}><p className="eyebrow">Explore the possibilities</p><h2>{item.name || item.title}</h2><p>{item.text}</p><span>Explore details <Arrow diagonal /></span></div>
  </a>)}</div></Localized>;
}
function Brief({ points, context }) {
  return <Localized><div className={styles.brief}><p className="eyebrow">Start with your requirements</p><h2>What matters<br /><span className="muted-heading">to your product?</span></h2><ul>{points.map(text=><li key={text}>{text}</li>)}</ul><p>Share your priorities, estimated quantity and timeline. We can discuss a suitable next step.</p><EnquiryButton context={context}>Discuss your requirement</EnquiryButton></div></Localized>;
}
function NextStep({context}){return <Localized><aside className={styles.next}><div><p className="eyebrow">Let’s develop it together</p><h2>Your next step<br /><span className="muted-heading">starts here.</span></h2></div><div><p>Have a product in mind? Talk to us about the material, application and sampling you need.</p><EnquiryButton context={context}>Start a conversation</EnquiryButton><a href={siteUrl("/contact")}>Contact details <Arrow diagonal /></a></div></aside></Localized>;}

export default function InsidePage({ page }) {
  const product=products.find(item=>item.slug===page.slug);
  const service=services.find(item=>item.slug===page.slug);
  const parent=page.type==='product'?'Products':page.type==='service'?'Services':null;
  const parentPath=parent?.toLowerCase();
  return <Localized><><Header/><main id="main-content" tabIndex={-1} className={styles.main}>
    <div className={`container ${styles.intro}`}>
      <nav aria-label="Breadcrumb" className={styles.breadcrumb}><a href={siteUrl("/")}>Home</a><span aria-hidden="true">/</span>{parent&&<><a href={siteUrl(`/${parentPath}`)}>{parent}</a><span aria-hidden="true">/</span></>}<span aria-current="page">{page.title}</span></nav>
      <p className="eyebrow">Fibro / Technical textiles</p>
      <h1>{page.title}</h1><p className={styles.lead}>{page.description}</p>
    </div>
    {['sustainability', 'manufacturing-quality'].includes(page.type) && <ResponsibilityContent type={page.type} />}
    {page.type === 'circular-textiles' && <div className="container"><CircularTextiles /></div>}
    {page.type==='about'&&<><AboutFibro standalone/><div className={`container ${styles.section}`}><div className={styles.twoColumns}><div><p className="eyebrow">Our approach</p><h2>From first idea<br/><span className="muted-heading">to final fabric.</span></h2></div><div>{[['Understand','Define the feel, function and application.'],['Develop','Sample the right textile, film and adhesive.'],['Refine','Agree the construction and quality criteria.']].map(([title,text])=><div className={styles.step} key={title}><h3>{title}</h3><p>{text}</p></div>)}</div></div><NextStep context="About Fibro"/></div></>}
    {page.type==='products'&&<div className={`container ${styles.section}`}><Cards items={products} base="/products"/><NextStep context="Product selection"/></div>}
    {page.type==='services'&&<div className={`container ${styles.section}`}><Cards items={services} base="/services"/><NextStep context="Services"/></div>}
    {(product||service)&&<div className={`container ${styles.section}`}>
      <div className={styles.detailGrid}>{product?.slug === 'bedding' ? <BeddingGallery /> : <div className={styles.detailImage}><Image src={`/images/${(product||service).image}`} alt={product?.alt || 'Illustrative textile material study'} fill sizes="(max-width: 850px) 100vw, 55vw" preload/><span>APPLICATION STUDY</span></div>}<Brief points={product?.considerations || service.points} context={(product||service).name}/></div>
      {product&&(()=>{const construction=materials.find(item=>item.id===product.construction) || materials[Number(product.construction)] || materials[0]; return <div className={styles.feature}><div><p className="eyebrow">Material possibilities</p><h2>{construction.name}</h2></div><div><p>{construction.details}</p><a className="text-link" href={siteUrl("/technology")}>Explore the technology <Arrow diagonal/></a></div></div>})()}
      {service&&<div className={styles.feature}><div><p className="eyebrow">A collaborative process</p><h2>Understand. Develop. Refine.</h2></div><div><p>Define the feel, function and care requirements, then develop and refine a suitable material construction.</p><p>Discuss the construction and quality criteria with our team before agreeing the next stage.</p></div></div>}
      <div className={styles.questions}><h2>Before we begin.</h2><details><summary>How do I request a sample?</summary><p>Choose “Request a sample” in the enquiry form and describe your application. Our team can discuss suitable samples and the next steps with you.</p></details><details><summary>What specifications are available?</summary><p>Specifications depend on the selected material and construction. Share your requirements so our team can confirm suitable options and evaluation criteria.</p></details></div>
      {product && <FabricSamples productSlug={product.slug} contained/>}
      {product?.slug === 'outdoor-furniture-covers' && <OutdoorPerformance />}
      {product?.slug === 'blackout-curtains' && <div className={styles.feature}><div><p className="eyebrow">Circular textiles</p><h2>Recycled polyester: a future development.</h2></div><div><p>Our recycled polyester blackout curtain fabric is planned for future development. This is separate from the existing blackout curtain range; recycled-content availability will be confirmed when the new construction is ready.</p><a className="text-link" href={siteUrl('/circular-textiles')}>Explore circular textiles</a></div></div>}
      {product?.slug === 'workwear-functional-fabrics' && <div className={styles.feature}><div><p className="eyebrow">Performance requirements</p><h2>Developed around your specification.</h2></div><div><p>We develop laminated fabrics for workwear projects targeting EN 343 rain-protection classes 1, 2, 3 or 4 for water penetration and water vapour resistance. Achievable classifications depend on the selected construction, seams and testing of the finished garment.</p><p>Fire-retardant performance is a separate requirement from EN 343 rain protection. Confirm the applicable specification and test evidence with our team.</p></div></div>}
      <NextStep context={(product||service).name}/><h2 className={styles.relatedTitle}>{product?'Explore other applications':'Explore other services'}</h2><Cards items={(product?products:services).filter(item=>item.slug!==page.slug).slice(0,3)} base={product?'/products':'/services'}/>
    </div>}
    {page.type==='technology'&&<><div className={`container ${styles.technology}`}><MaterialExplorer/></div><div className={`container ${styles.section}`}>{materials.map(item=><div key={item.id} className={styles.feature}><div><p className="eyebrow">{item.category}</p><h2>{item.name}</h2></div><div><p>{item.details}</p><p>{item.attributes}</p><EnquiryButton context={item.name}>Enquire about this material</EnquiryButton></div></div>)}<NextStep context="Materials & Technology"/></div></>}
    {page.type==='contact'&&<div className={`container ${styles.section}`}><div className={styles.contactGrid}><div><p className="eyebrow">Start a conversation</p><h2>Tell us what<br/><span className="muted-heading">you have in mind.</span></h2><address className={styles.contactDetails}><strong>{company.name}</strong><span>{company.address}<br/>{company.locality}</span><a href={company.mobileHref}>{company.mobile}</a><a href={`mailto:${company.email}`}>{company.email}</a><a className="text-link" href={company.whatsappHref} target="_blank" rel="noopener noreferrer">WhatsApp <Arrow diagonal/></a></address></div><div className={styles.contactForm}><EnquiryForm context="General enquiry"/><p className={styles.small}>Your details are used to review and respond to your enquiry. Please contact us by email if you need to update a submission.</p></div></div></div>}
  </main><Footer/><WhatsApp/></></Localized>;
}
