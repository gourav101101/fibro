export const responsibilityPages = [
  { id: 'circular-textiles', path: '/circular-textiles', title: 'Circular textiles', description: 'Recycled inputs and design for recyclability: two distinct approaches to keeping textile materials in use.', type: 'circular-textiles' },
  { id: 'sustainability', path: '/sustainability', title: 'Environment & Sustainability', description: 'A closer look at our hot-melt process and the material questions behind responsible sourcing.', type: 'sustainability' },
  { id: 'manufacturing-quality', path: '/manufacturing-quality', title: 'Manufacturing & Quality', description: 'Coating, lamination and development, with your application and quality requirements at the centre.', type: 'manufacturing-quality' },
];

const cms = globalThis.__FIBRO_CMS__ || {};
const defaultProgrammes = [
  { name: 'Global Recycled Standard', image: 'grs.png', category: 'Recycled content & chain of custody' },
  { name: 'ISO 9001:2015', image: 'iso-9001.png', category: 'Quality management standard' },
  { name: 'Sedex', image: 'sedex.jpg', category: 'Responsible sourcing platform' },
  { name: 'ISPF', image: 'ispf.png', category: 'Indian Sleep Products Federation' },
];
export const programmes = cms.certifications?.length ? cms.certifications : defaultProgrammes;

export const responsibilityTopics = {
  sustainability: [
    ['The process', 'Hot-melt coating', 'Our dry hot-melt coating process applies adhesive without water or solvent carriers. This describes the coating step; material selection and the complete product construction remain important.'],
    ['The material', 'Start with the application', 'Discuss the textile, foam or membrane around the function, feel and care your product needs. Recycled-content requirements and supporting documentation can be part of your enquiry.'],
    ['The evidence', 'Ask the right questions', 'For a sourcing requirement, ask our team about the applicable material, certificate scope and supporting documents. Agree the details for your selected construction before placing an order.'],
  ],
  'manufacturing-quality': [
    ['Our capabilities', 'Bring materials together', 'Fibro develops fabric-to-fabric, fabric-to-foam and fabric-to-membrane constructions using hot-melt coating and lamination. Digital printing and custom development extend the conversation around your finished product.'],
    ['Development', 'Define. Sample. Refine.', 'Start with the application, substrate and finish. Discuss a sample and the points to review, then refine the construction around the agreed requirements.'],
    ['Quality requirements', 'Agree what matters', 'Share the dimensions, surface feel, bonding, care and performance criteria your product needs. Discuss suitable evaluation and documentation with our team before confirming production requirements.'],
  ],
};
