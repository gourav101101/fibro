import { responsibilityPages } from './responsibility';
import { applications } from './company';

const slugs = ['luggage-fabrics','outdoor-furniture-covers','reusable-sanitary-pad-fabrics','outdoor-wear','bedding','baby-cloth-fabrics','intimate-apparel','waterproof-insole-fabrics','automotive'];
const questions = [
  ['Bag type and intended use','Surface appearance and handle','Structure, backing and finish'],
  ['Furniture size and cover design','Exposure and water protection','Flexibility and care requirements'],
  ['Product layers and intended use','Surface feel and barrier needs','Repeated-care requirements'],
  ['Garment design and intended conditions','Protection and comfort priorities','Layer construction and care'],
  ['Protector design and textile surface','Barrier and comfort requirements','Washing and care expectations'],
  ['Baby product and intended use','Surface softness and layer construction','Care and barrier requirements'],
  ['Cup or pad design','Shape, support and surface feel','Textile and foam selection'],
  ['Shoe design and insole application','Water protection and comfort','Construction and evaluation criteria'],
  ['Seat cover or headliner application','Surface texture and cushioning','Construction and project specifications'],
];
export const products = applications.map((item,index)=>({slug:slugs[index],considerations:questions[index],construction:[0,2,2,2,2,2,1,2,1][index],...item}));
const cms = globalThis.__FIBRO_CMS__ || {};
const defaultServices = [
  {slug:'hot-melt-coating',name:'Hot-melt coating',title:'A considered starting point.',text:'Apply hot-melt adhesives without water or solvent carriers. Discuss the substrate, finish and bonding requirements of your product.',image:'process-material-study.png',points:['Substrate and surface requirements','Adhesive and bonding requirements','Sampling and evaluation criteria']},
  {slug:'pur-lamination',name:'PUR lamination',title:'Function through combination.',text:'Bring textiles, foams and membranes together in a construction developed around your application.',image:'hero-precision-layers.png',points:['Textile, foam or membrane selection','Feel, function and finished construction','Bonding and care requirements']},
  {slug:'digital-printing',name:'Digital printing',title:'Your design, on fabric.',text:'Explore digital printing for your textile project. Share your artwork, fabric and intended use so we can discuss suitability and sampling.',image:'product-laminated.jpg',points:['Artwork and intended print placement','Fabric, colour and finish expectations','Sample review before agreeing production']},
  {slug:'custom-development',name:'Custom development',title:'Your brief comes first.',text:'Define the feel, function and care requirements, then develop and refine a suitable material construction.',image:'product-tpu.jpg',points:['Product application and priorities','Material combinations to explore','Evaluation, refinement and next steps']},
];
export const services = cms.services?.length ? cms.services : defaultServices;
export const pages = [
  ...responsibilityPages,
  {id:'home',path:'/',title:'Fibro Laminates | Technical Textiles, Thoughtfully Engineered',description:'Explore technical fabrics, coating, PUR lamination and digital printing from Fibro Laminates.',type:'home'},
  {id:'about',path:'/about',title:'About Fibro',description:'Our story, vision, mission and values: integrity, innovation and excellence.',type:'about'},
  {id:'products',path:'/products',title:'Products',description:'Explore fabrics for luggage, outdoor covers, hygiene, apparel, bedding, footwear and automotive applications.',type:'products'},
  ...products.map(item=>({id:'product-'+item.slug,path:'/products/'+item.slug,title:item.name,description:item.text,image:item.image,type:'product',slug:item.slug})),
  {id:'services',path:'/services',title:'Services',description:'Coating, PUR lamination, digital printing and custom textile development.',type:'services'},
  ...services.map(item=>({id:'service-'+item.slug,path:'/services/'+item.slug,title:item.name,description:item.text,image:item.image,type:'service',slug:item.slug})),
  {id:'technology',path:'/technology',title:'Materials & Technology',description:'Explore fabric-to-fabric, fabric-to-foam and fabric-to-membrane constructions.',type:'technology'},
  {id:'contact',path:'/contact',title:'Contact Fibro',description:'Discuss your product, request a sample or send a textile requirement to Fibro Laminates.',type:'contact'},
];
