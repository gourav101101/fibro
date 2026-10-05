<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductCategoryUpdateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_update_preserves_admin_edits_and_can_be_repeated(): void
    {
        $cover = Product::create(['slug' => 'outdoor-furniture-covers', 'name' => 'Outdoor furniture covers', 'image' => 'product-blackout.jpg']);
        $hygiene = Product::create(['slug' => 'reusable-sanitary-pad-fabrics', 'name' => 'Custom hygiene range', 'image' => 'uploads/customer-photo.jpg']);
        $baby = Product::create(['slug' => 'baby-cloth-fabrics', 'name' => 'Baby cloth fabrics', 'image' => 'product-baby.jpg', 'text' => 'Admin-authored description']);
        $this->seed(ProductCategoryUpdateSeeder::class);
        $this->assertSame('fibro-outdoor-cover.jpg', $cover->fresh()->image);
        $this->assertSame('uploads/customer-photo.jpg', $hygiene->fresh()->image);
        $this->assertSame('fibro-diaper-watermelon.jpg', $baby->fresh()->image);
        $this->assertSame('Reusable baby cloth diaper fabrics', $baby->fresh()->name);
        $this->assertSame('Admin-authored description', $baby->fresh()->text);
        $this->assertDatabaseHas('products', ['slug' => 'blackout-curtains', 'image' => 'fibro-blackout-curtain.jpg']);
        $this->assertDatabaseHas('pages', ['page_key' => 'circular-textiles']);
        $workwear = Product::where('slug', 'workwear-functional-fabrics')->firstOrFail();
        $workwear->update(['title' => 'Admin-edited title', 'is_active' => false]);
        $this->seed(ProductCategoryUpdateSeeder::class);
        $this->assertSame(1, Product::where('slug', 'workwear-functional-fabrics')->count());
        $this->assertSame('Admin-edited title', $workwear->fresh()->title);
        $this->assertFalse($workwear->fresh()->is_active);
    }
}
