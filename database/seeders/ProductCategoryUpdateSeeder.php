<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Page;
use Illuminate\Database\Seeder;

class ProductCategoryUpdateSeeder extends Seeder
{
    public function run(): void
    {
        // Replace only the old supplied placeholders; preserve later admin uploads.
        foreach ([
            ['outdoor-furniture-covers', 'product-blackout.jpg', 'fibro-outdoor-cover.jpg', 'Grey woven fabric with silver backing'],
            ['reusable-sanitary-pad-fabrics', 'product-tpu.jpg', 'fibro-period-panty-liner.jpg', 'Grey fabric with silver reverse side'],
            ['baby-cloth-fabrics', 'product-baby.jpg', 'fibro-diaper-watermelon.jpg', 'Watermelon print with reverse side'],
        ] as [$slug, $oldImage, $image, $alt]) {
            Product::where('slug', $slug)->whereIn('image', [$oldImage, '/images/'.$oldImage, 'images/'.$oldImage])
                ->update(['image' => $image, 'alt' => $alt]);
            Page::where('page_key', 'product-'.$slug)->whereIn('og_image', [$oldImage, '/images/'.$oldImage, 'images/'.$oldImage])
                ->update(['og_image' => $image]);
        }

        $oldBabyDescription = 'Polar fleece and TPU membrane constructions for baby underlays. Discuss surface feel, moisture management and care requirements for your product.';
        $babyDescription = 'Printed laminated fabrics for reusable baby cloth diapers, alongside constructions for baby underlays. Discuss surface feel, barrier performance and repeated-care requirements.';
        Product::where('slug', 'baby-cloth-fabrics')->where('text', $oldBabyDescription)->update(['text' => $babyDescription]);
        Page::where('page_key', 'product-baby-cloth-fabrics')->where('description', $oldBabyDescription)->update(['description' => $babyDescription]);
        Product::where('slug', 'baby-cloth-fabrics')->where('name', 'Baby cloth fabrics')->update([
            'name' => 'Reusable baby cloth diaper fabrics',
        ]);
        Page::where('page_key', 'product-baby-cloth-fabrics')->where('title', 'Baby cloth fabrics')
            ->update(['title' => 'Reusable baby cloth diaper fabrics']);
        foreach (['workwear', 'blackout'] as $category) {
            $product = json_decode(file_get_contents(resource_path('data/'.$category.'.json')), true, 512, JSON_THROW_ON_ERROR);
            Product::firstOrCreate(['slug' => $product['slug']], $product + [
                'sort_order' => ((int) Product::max('sort_order')) + 1,
                'is_active' => true,
            ]);
            Page::firstOrCreate(['page_key' => 'product-'.$product['slug']], [
                'title' => $product['name'], 'description' => $product['text'], 'is_active' => true,
            ]);
        }
        Page::firstOrCreate(['page_key' => 'circular-textiles'], [
            'title' => 'Circular textiles',
            'description' => 'Recycled inputs and design for recyclability: two distinct approaches to keeping textile materials in use.',
            'is_active' => true,
        ]);
    }
}
