import Image from "@/components/Image";
import styles from "./Brand.module.css";
import { siteUrl } from "@/utils/siteUrl";

export default function Brand({ inverse = false }) {
  return <a href={siteUrl("/")} className={`${styles.brand} ${styles.compact} ${inverse ? styles.inverse : ""}`} aria-label="Fibro Laminates home">
    <span className={styles.symbol}><Image src="/images/fibro-symbol-refined.png" alt="" width={64} height={64} sizes="64px" /></span>
    <span className={styles.wordmark}><Image src="/images/fibro-official-logo.png" alt="" width={1796} height={503} preload={!inverse} /></span>
  </a>;
}
