// Responsive files are generated at build time; PHP hosting needs no image service.
import { publicImageUrl } from "@/utils/siteUrl";

export default function Image({ src, alt, fill, sizes, preload, priority, quality: _quality, style, ...props }) {
  const eager = preload || priority;
  const responsive = fill && !src.includes('/uploads/') && /\.(png|jpe?g)$/i.test(src);
  const name = (src.startsWith('/images/') ? src.slice('/images/'.length) : src.split('/').pop()).replace(/\.[^.]+$/, '');
  return <img {...props} alt={alt} src={publicImageUrl(responsive ? `/images/optimized/${name}-1280.webp` : src)}
    srcSet={responsive ? [480, 800, 1280, 1920].map(width => `${publicImageUrl(`/images/optimized/${name}-${width}.webp`)} ${width}w`).join(', ') : undefined}
    sizes={sizes} loading={eager ? 'eager' : 'lazy'} fetchPriority={eager ? 'high' : undefined} decoding="async"
    style={{ ...(fill ? { position: 'absolute', width: '100%', height: '100%', inset: 0 } : {}), ...style }} />;
}
