// Contact: user-confirmed mailbox and supplied company email signature.
// Capabilities/applications: company brochure and client brief of 14 September 2026.
// See docs/company-content-brief.md and docs/client-homepage-brief.md.
const cms = globalThis.__FIBRO_CMS__ || {};
import workwear from '../../../data/workwear.json';
import blackout from '../../../data/blackout.json';
const defaultCompany = {
  name: "Fibro Laminates Pvt Ltd",
  email: "fibrolaminates@gmail.com",
  mobile: "+91 99252 39699",
  mobileHref: "tel:+919925239699",
  whatsappHref: "https://wa.me/919925239699?text=Hello%20Fibro%2C%20I%27d%20like%20to%20discuss%20a%20textile%20requirement.",
  // User requested platform homepages until official Fibro profiles exist.
  socialLinks: [
    { label: "LinkedIn", href: "https://www.linkedin.com/", accessibleLabel: "LinkedIn website" },
    { label: "Instagram", href: "https://www.instagram.com/", accessibleLabel: "Instagram website" },
    { label: "Facebook", href: "https://www.facebook.com/", accessibleLabel: "Facebook website" },
  ],
  address: "Plot No. 6125, Road No. 61, GIDC Sachin",
  locality: "Surat, Gujarat 394230, India",
};
export const company = { ...defaultCompany, ...(cms.company || {}) };

const defaultMaterials = [
  { id: "fabric", name: "Fabric to fabric", category: "Textiles, brought together", image: "/images/product-laminated.jpg", alt: "Illustrative collection of woven textile rolls", use: "Knitted, woven & nonwoven textiles", description: "Combine surfaces, textures and textile properties.", details: "Bring knitted, woven or nonwoven fabrics together through hot-melt lamination. Discuss the composition, handle, stretch and bond requirements of your finished product.", attributes: "Textile combinations · Custom development" },
  { id: "foam", name: "Fabric to foam", category: "Comfort takes shape", image: "/images/application-foam.png", alt: "Illustrative foam-backed knitted fabric and moulded cup components", use: "Intimate apparel & automotive interiors", description: "Bring softness, cushioning and structure together.", details: "Laminate textiles to PU, EPE or EVA foam. Applications include moulded bra cups and pads, automotive seat covers and headliners. Select the foam and textile around the product requirements.", attributes: "PU · EPE · EVA foams" },
  { id: "membrane", name: "Fabric to membrane", category: "Function, within the layers", image: "/images/product-tpu.jpg", alt: "Illustrative close-up of textile and membrane layers", use: "Outdoor wear, bedding & footwear", description: "Develop the barrier your application needs.", details: "Combine fabric with TPU, TPE or PTFE membranes, or PE film. Waterproofness, breathability and wash performance depend on the membrane and the complete construction; define these requirements with our team.", attributes: "TPU · TPE · PTFE membranes · PE film" },
];
export const materials = cms.materials?.length ? cms.materials : defaultMaterials;

const defaultApplications = [
  {"name":"Luggage fabrics","title":"Made for the journey.","text":"Explore fabrics for bags and luggage. Tell us about the look, handle, structure and finish your product needs so we can discuss a suitable construction.","material":"Fabrics for bags & luggage","image":"product-luggage.jpg","alt":"Illustrative luggage fabric application"},
  {"name":"Outdoor furniture covers","title":"Cover what matters.","text":"Fabrics for protective outdoor furniture covers. Define water protection, exposure, flexibility and care requirements with our team.","material":"Protective cover fabrics","image":"product-blackout.jpg","alt":"Illustrative technical fabric study for protective covers"},
  {"name":"Reusable sanitary pad fabrics","title":"Thoughtful layers for reuse.","text":"Explore fabric constructions for reusable sanitary pads. Discuss surface feel, barrier requirements and repeated-care needs for your intended product.","material":"Textiles for reusable hygiene products","image":"product-tpu.jpg","alt":"Illustrative textile and membrane layers"},
  { name: "Outdoor wear", title: "Ready for the elements.", text: "Multilayer textile constructions for jackets, windcheaters and sports gear. Select the membrane around your protection, breathability and comfort requirements.", material: "Textile + membrane constructions", image: "product-highalt.jpg", alt: "Illustrative layered outdoor fabric with water droplets" },
  { name: "Bedding", title: "Rest, protected.", text: "Terry, woven and knitted textiles laminated to TPU membranes for mattress and bed protectors. Develop around feel, barrier requirements and care.", material: "Textile + TPU membrane", image: "fibro-bedding.jpg", alt: "White fitted bedding on a bed with a blue upholstered headboard" },
  { name: "Baby cloth fabrics", title: "Comfort in every layer.", text: "Polar fleece and TPU membrane constructions for baby underlays. Discuss surface feel, moisture management and care requirements for your product.", material: "Polar fleece + TPU membrane", image: "product-baby.jpg", alt: "Illustrative soft baby-care textile" },
  { name: "Intimate apparel", title: "Softness, shaped.", text: "Knitted textiles laminated to aliphatic foam for moulded bra cups and pads. Develop around the shape, support and feel your design needs.", material: "Knitted textile + foam", image: "application-foam.png", alt: "Illustrative moulded cups beside a foam-backed knitted textile sample" },
  { name: "Waterproof insole fabrics", title: "Comfort with every step.", text: "Waterproof insole fabrics and textile-membrane shoe interlinings for footwear development. Discuss construction and testing needs for your shoe design.", material: "Insole fabrics & shoe interlinings", image: "application-footwear.png", alt: "Illustrative outdoor shoe and textile lining swatch" },
  { name: "Automotive", title: "A considered interior.", text: "Foam-laminated textiles for automotive seat covers and headliners. Bring surface texture and cushioning together around your interior specification.", material: "Textile + foam constructions", image: "application-automotive.png", alt: "Illustrative automotive seats in woven textile upholstery" },
];
// Keep admin uploads intact while replacing the two original placeholder images.
const correctedImages = {
  'Outdoor furniture covers': ['product-blackout.jpg', 'fibro-outdoor-cover.jpg', 'Grey woven fabric with silver backing'],
  'Reusable sanitary pad fabrics': ['product-tpu.jpg', 'fibro-period-panty-liner.jpg', 'Grey fabric with silver reverse side'],
  'Baby cloth fabrics': ['product-baby.jpg', 'fibro-diaper-watermelon.jpg', 'Watermelon print with reverse side'],
};
export const applications = (cms.products?.length ? cms.products : [...defaultApplications, workwear, blackout]).map(item => {
  const replacement = correctedImages[item.name];
  const updated = replacement && item.image === replacement[0] ? { ...item, image: replacement[1], alt: replacement[2] } : item;
  return updated.name === 'Baby cloth fabrics' ? { ...updated, name: 'Reusable baby cloth diaper fabrics', text: 'Printed laminated fabrics for reusable baby cloth diapers, alongside constructions for baby underlays. Discuss surface feel, barrier performance and repeated-care requirements.' } : updated;
});
