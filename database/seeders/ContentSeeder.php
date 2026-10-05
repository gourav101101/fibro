<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Service;
use App\Models\Material;
use App\Models\HeroStory;
use App\Models\CompanySetting;
use App\Models\Certification;
use App\Models\Page;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Company Settings
        $company = [
            'name' => 'Fibro Laminates Pvt Ltd',
            'email' => 'fibrolaminates@gmail.com',
            'mobile' => '+91 99252 39699',
            'mobileHref' => 'tel:+919925239699',
            'whatsappHref' => 'https://wa.me/919925239699?text=Hello%20Fibro%2C%20I%27d%20like%20to%20discuss%20a%20textile%20requirement.',
            'address' => 'Plot No. 6125, Road No. 61, GIDC Sachin',
            'locality' => 'Surat, Gujarat 394230, India',
            'socialLinks' => json_encode([
                ['label' => 'LinkedIn', 'href' => 'https://www.linkedin.com/', 'accessibleLabel' => 'LinkedIn website'],
                ['label' => 'Instagram', 'href' => 'https://www.instagram.com/', 'accessibleLabel' => 'Instagram website'],
                ['label' => 'Facebook', 'href' => 'https://www.facebook.com/', 'accessibleLabel' => 'Facebook website'],
            ])
        ];

        foreach ($company as $key => $value) {
            CompanySetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Materials
        $materials = [
            ['key' => 'fabric', 'name' => 'Fabric to fabric', 'category' => 'Textiles, brought together', 'image' => '/images/product-laminated.jpg', 'alt' => 'Illustrative collection of woven textile rolls', 'use' => 'Knitted, woven & nonwoven textiles', 'description' => 'Combine surfaces, textures and textile properties.', 'details' => 'Bring knitted, woven or nonwoven fabrics together through hot-melt lamination. Discuss the composition, handle, stretch and bond requirements of your finished product.', 'attributes' => 'Textile combinations · Custom development'],
            ['key' => 'foam', 'name' => 'Fabric to foam', 'category' => 'Comfort takes shape', 'image' => '/images/application-foam.png', 'alt' => 'Illustrative foam-backed knitted fabric and moulded cup components', 'use' => 'Intimate apparel & automotive interiors', 'description' => 'Bring softness, cushioning and structure together.', 'details' => 'Laminate textiles to PU, EPE or EVA foam. Applications include moulded bra cups and pads, automotive seat covers and headliners. Select the foam and textile around the product requirements.', 'attributes' => 'PU · EPE · EVA foams'],
            ['key' => 'membrane', 'name' => 'Fabric to membrane', 'category' => 'Function, within the layers', 'image' => '/images/product-tpu.jpg', 'alt' => 'Illustrative close-up of textile and membrane layers', 'use' => 'Outdoor wear, bedding & footwear', 'description' => 'Develop the barrier your application needs.', 'details' => 'Combine fabric with TPU, TPE or PTFE membranes, or PE film. Waterproofness, breathability and wash performance depend on the membrane and the complete construction; define these requirements with our team.', 'attributes' => 'TPU · TPE · PTFE membranes · PE film'],
        ];

        foreach ($materials as $i => $m) {
            $m['attributes'] = json_encode([$m['attributes']]); // storing as array in DB to match JSON struct
            $m['sort_order'] = $i;
            Material::updateOrCreate(['key' => $m['key']], $m);
        }

        // 3. Products
        $slugs = ['luggage-fabrics','outdoor-furniture-covers','reusable-sanitary-pad-fabrics','outdoor-wear','bedding','baby-cloth-fabrics','intimate-apparel','waterproof-insole-fabrics','automotive'];
        $questions = [
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
        $constructions = [0,2,2,2,2,2,1,2,1]; // Indices mapping to materials array
        $applications = [
            ['name' => 'Luggage fabrics', 'title' => 'Made for the journey.', 'text' => 'Explore fabrics for bags and luggage. Tell us about the look, handle, structure and finish your product needs so we can discuss a suitable construction.', 'material' => 'Fabrics for bags & luggage', 'image' => 'product-luggage.jpg', 'alt' => 'Illustrative luggage fabric application'],
            ['name' => 'Outdoor furniture covers', 'title' => 'Cover what matters.', 'text' => 'Fabrics for protective outdoor furniture covers. Define water protection, exposure, flexibility and care requirements with our team.', 'material' => 'Protective cover fabrics', 'image' => 'product-blackout.jpg', 'alt' => 'Illustrative technical fabric study for protective covers'],
            ['name' => 'Reusable sanitary pad fabrics', 'title' => 'Thoughtful layers for reuse.', 'text' => 'Explore fabric constructions for reusable sanitary pads. Discuss surface feel, barrier requirements and repeated-care needs for your intended product.', 'material' => 'Textiles for reusable hygiene products', 'image' => 'product-tpu.jpg', 'alt' => 'Illustrative textile and membrane layers'],
            ['name' => 'Outdoor wear', 'title' => 'Ready for the elements.', 'text' => 'Multilayer textile constructions for jackets, windcheaters and sports gear. Select the membrane around your protection, breathability and comfort requirements.', 'material' => 'Textile + membrane constructions', 'image' => 'product-highalt.jpg', 'alt' => 'Illustrative layered outdoor fabric with water droplets'],
            ['name' => 'Bedding', 'title' => 'Rest, protected.', 'text' => 'Terry, woven and knitted textiles laminated to TPU membranes for mattress and bed protectors. Develop around feel, barrier requirements and care.', 'material' => 'Textile + TPU membrane', 'image' => 'product-mattress.jpg', 'alt' => 'Illustrative bedroom with a layered mattress protector'],
            ['name' => 'Baby cloth fabrics', 'title' => 'Comfort in every layer.', 'text' => 'Polar fleece and TPU membrane constructions for baby underlays. Discuss surface feel, moisture management and care requirements for your product.', 'material' => 'Polar fleece + TPU membrane', 'image' => 'product-baby.jpg', 'alt' => 'Illustrative soft baby-care textile'],
            ['name' => 'Intimate apparel', 'title' => 'Softness, shaped.', 'text' => 'Knitted textiles laminated to aliphatic foam for moulded bra cups and pads. Develop around the shape, support and feel your design needs.', 'material' => 'Knitted textile + foam', 'image' => 'application-foam.png', 'alt' => 'Illustrative moulded cups beside a foam-backed knitted textile sample'],
            ['name' => 'Waterproof insole fabrics', 'title' => 'Comfort with every step.', 'text' => 'Waterproof insole fabrics and textile-membrane shoe interlinings for footwear development. Discuss construction and testing needs for your shoe design.', 'material' => 'Insole fabrics & shoe interlinings', 'image' => 'application-footwear.png', 'alt' => 'Illustrative outdoor shoe and textile lining swatch'],
            ['name' => 'Automotive', 'title' => 'A considered interior.', 'text' => 'Foam-laminated textiles for automotive seat covers and headliners. Bring surface texture and cushioning together around your interior specification.', 'material' => 'Textile + foam constructions', 'image' => 'application-automotive.png', 'alt' => 'Illustrative automotive seats in woven textile upholstery'],
        ];
        
        foreach ($applications as $i => &$app) {
            $constMap = ['fabric', 'foam', 'membrane'];
            $app['slug'] = $slugs[$i];
            $app['considerations'] = $questions[$i];
            $app['construction'] = $constMap[$constructions[$i]];
            $app['sort_order'] = $i;
            Product::updateOrCreate(['slug' => $app['slug']], $app);
        }
        unset($app); // break the reference

        // 4. Services
        $services = [
            ['slug' => 'hot-melt-coating', 'name' => 'Hot-melt coating', 'title' => 'A considered starting point.', 'text' => 'Apply hot-melt adhesives without water or solvent carriers. Discuss the substrate, finish and bonding requirements of your product.', 'image' => 'process-material-study.png', 'points' => ['Substrate and surface requirements','Adhesive and bonding requirements','Sampling and evaluation criteria']],
            ['slug' => 'pur-lamination', 'name' => 'PUR lamination', 'title' => 'Function through combination.', 'text' => 'Bring textiles, foams and membranes together in a construction developed around your application.', 'image' => 'hero-precision-layers.png', 'points' => ['Textile, foam or membrane selection','Feel, function and finished construction','Bonding and care requirements']],
            ['slug' => 'digital-printing', 'name' => 'Digital printing', 'title' => 'Your design, on fabric.', 'text' => 'Explore digital printing for your textile project. Share your artwork, fabric and intended use so we can discuss suitability and sampling.', 'image' => 'product-laminated.jpg', 'points' => ['Artwork and intended print placement','Fabric, colour and finish expectations','Sample review before agreeing production']],
            ['slug' => 'custom-development', 'name' => 'Custom development', 'title' => 'Your brief comes first.', 'text' => 'Define the feel, function and care requirements, then develop and refine a suitable material construction.', 'image' => 'product-tpu.jpg', 'points' => ['Product application and priorities','Material combinations to explore','Evaluation, refinement and next steps']],
        ];

        foreach ($services as $i => $s) {
            $s['sort_order'] = $i;
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }

        // 5. Hero Stories
        $stories = [
            ['label' => 'Materials with purpose', 'eyebrow' => 'FIBRO / TECHNICAL TEXTILES & LAMINATION', 'title_line1' => 'Technical fabrics.', 'title_line2' => 'Your possibilities.', 'accent' => 'Developed together.', 'description' => 'Coating, lamination and digital printing for your next product.', 'image' => '/images/product-highalt.jpg', 'alt' => 'Illustrative technical textile layers with water droplets', 'action_text' => 'Explore our products', 'action_href' => '#applications', 'is_dark' => true],
            ['label' => 'Protection in every layer', 'eyebrow' => 'FIBRO / PERFORMANCE MATERIALS', 'title_line1' => 'Made for', 'title_line2' => 'the elements.', 'accent' => 'Ready for more.', 'description' => 'Protection, comfort and freedom to move. Explore technical fabric constructions developed around your application.', 'image' => '/images/product-tpu.jpg', 'alt' => 'Illustrative fabric and functional membrane construction', 'action_text' => 'Explore the technology', 'action_href' => '#technology', 'is_dark' => true],
            ['label' => 'Precision in every process', 'eyebrow' => 'FIBRO / COATING & PUR LAMINATION', 'title_line1' => 'Great ideas.', 'title_line2' => 'Expertly made.', 'accent' => 'Layer by layer.', 'description' => 'Material knowledge meets precision bonding. From your first brief to a considered textile construction.', 'image' => '/images/hero-precision-layers.png', 'alt' => 'Conceptual study of teal woven textile, translucent film and ivory backing meeting in a curved layered edge', 'action_text' => 'Meet the process', 'action_href' => '#manufacturing', 'is_dark' => true],
        ];

        foreach ($stories as $i => $st) {
            $st['sort_order'] = $i;
            HeroStory::updateOrCreate(['label' => $st['label']], $st);
        }

        // 6. Certifications
        $certifications = [
            ['name' => 'Global Recycled Standard', 'image' => 'credentials/grs.png', 'category' => 'Recycled content & chain of custody'],
            ['name' => 'ISO 9001:2015', 'image' => 'credentials/iso-9001.png', 'category' => 'Quality management standard'],
            ['name' => 'Sedex', 'image' => 'credentials/sedex.jpg', 'category' => 'Responsible sourcing platform'],
            ['name' => 'ISPF', 'image' => 'credentials/ispf.png', 'category' => 'Indian Sleep Products Federation'],
        ];

        foreach ($certifications as $i => $c) {
            $c['sort_order'] = $i;
            Certification::updateOrCreate(['name' => $c['name']], $c);
        }

        // 7. Pages (SEO)
        $pages = [
            ['page_key' => 'sustainability', 'title' => 'Environment & Sustainability', 'description' => 'A closer look at our hot-melt process and the material questions behind responsible sourcing.'],
            ['page_key' => 'manufacturing-quality', 'title' => 'Manufacturing & Quality', 'description' => 'Coating, lamination and development, with your application and quality requirements at the centre.'],
            ['page_key' => 'home', 'title' => 'Fibro Laminates | Technical Textiles, Thoughtfully Engineered', 'description' => 'Explore technical fabrics, coating, PUR lamination and digital printing from Fibro Laminates.'],
            ['page_key' => 'about', 'title' => 'About Fibro', 'description' => 'Our story, vision, mission and values: integrity, innovation and excellence.'],
            ['page_key' => 'products', 'title' => 'Products', 'description' => 'Explore fabrics for luggage, outdoor covers, hygiene, apparel, bedding, footwear and automotive applications.'],
            ['page_key' => 'services', 'title' => 'Services', 'description' => 'Coating, PUR lamination, digital printing and custom textile development.'],
            ['page_key' => 'technology', 'title' => 'Materials & Technology', 'description' => 'Explore fabric-to-fabric, fabric-to-foam and fabric-to-membrane constructions.'],
            ['page_key' => 'contact', 'title' => 'Contact Fibro', 'description' => 'Discuss your product, request a sample or send a textile requirement to Fibro Laminates.'],
        ];

        // Also add product pages
        foreach ($applications as $app) {
            $pages[] = [
                'page_key' => 'product-' . $app['slug'],
                'title' => $app['name'],
                'description' => $app['text'],
                'og_image' => $app['image'],
            ];
        }

        // Also add service pages
        foreach ($services as $srv) {
            $pages[] = [
                'page_key' => 'service-' . $srv['slug'],
                'title' => $srv['name'],
                'description' => $srv['text'],
                'og_image' => $srv['image'],
            ];
        }

        foreach ($pages as $p) {
            Page::updateOrCreate(['page_key' => $p['page_key']], $p);
        }
        $this->call(ProductCategoryUpdateSeeder::class);
    }
}
