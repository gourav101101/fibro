
import { Localized } from "@/components/Language/Language";import EnquiryButton from "@/components/EnquiryButton/EnquiryButton";
import Brand from "@/components/Brand/Brand";
import styles from "./Footer.module.css";
import { siteUrl } from "@/utils/siteUrl";
import { company } from "@/data/company";
import { WhatsAppIcon } from "@/components/WhatsApp/WhatsApp";
import SocialIcon from "@/components/SocialIcon/SocialIcon";

export default function Footer() {
  return <Localized><footer id="contact" className={styles.footer}>
    <div className="container">
      <div className={styles.contact}>
        <div><p className="eyebrow">Start a conversation</p><h2>The next possibility<br />starts with <span>you.</span></h2></div>
        <div className={styles.contactCopy}><p>Have a material challenge or a product in mind? Let&apos;s find the right construction, together.</p><EnquiryButton className={styles.emailAction}>Let&apos;s create together</EnquiryButton><a className={styles.email} href={`mailto:${company.email}`}>{company.email}</a><address className={styles.address}>{company.address}<br />{company.locality}<div><a href={company.mobileHref}>{company.mobile}</a></div></address></div>
      </div>
      <div className={styles.bottom}>
        <div className={styles.brandBlock}><Brand inverse /><p className={styles.tagline}>Specializes in hot-melt coating &amp; lamination</p></div>
        <nav aria-label="Footer navigation"><a href={siteUrl("/products")}>Materials</a><a href={siteUrl("/about")}>About Fibro</a><a href={siteUrl("/services")}>Our services</a><a href={siteUrl("/sustainability")}>Sustainability</a><a href={siteUrl("/manufacturing-quality")}>Manufacturing & Quality</a><a href={siteUrl("/contact")}>Contact Fibro</a></nav>
        <a href="#" className={styles.backTop}>Back to top <span aria-hidden="true">↑</span></a>
      </div>
      <div className={styles.legal}><span>© {new Date().getFullYear()} Fibro Laminates Pvt Ltd.</span><nav className={styles.socials} aria-label="Connect with Fibro"><a href={company.whatsappHref} target="_blank" rel="noopener noreferrer" aria-label="Chat with Fibro on WhatsApp (opens a new tab)"><WhatsAppIcon />WhatsApp</a><span className={styles.platformLabel}>Platform links</span>{company.socialLinks.map(profile => <a key={profile.href} aria-label={profile.accessibleLabel} href={profile.href} target="_blank" rel="noopener noreferrer"><SocialIcon name={profile.label} />{profile.label}<span aria-hidden="true">↗</span></a>)}</nav></div>
      <p className={styles.credit}><span>Powered by</span>{' '}<a href="https://mdarena.in/" target="_blank" rel="noopener noreferrer"><strong>MAK Digital Arena</strong><span aria-hidden="true"> ↗</span></a></p>
    </div>
  </footer></Localized>;
}
