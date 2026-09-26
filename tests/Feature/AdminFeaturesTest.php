<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Certification;
use App\Models\Enquiry;
use App\Models\HeroStory;
use App\Models\Material;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use Database\Seeders\ContentSeeder;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
        $this->admin = AdminUser::create([
            'name' => 'Admin Test',
            'email' => 'admin@example.test',
            'password' => 'test-password',
        ]);
    }

    public function test_admin_authentication_and_protection_work(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->post('/admin/login', ['email' => $this->admin->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->post('/admin/login', ['email' => $this->admin->email, 'password' => 'test-password'])
            ->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin, 'admin');
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest('admin');
    }

    public function test_every_admin_screen_renders_for_an_authenticated_admin(): void
    {
        $this->actingAs($this->admin, 'admin');
        $paths = [
            '/admin', '/admin/enquiries', '/admin/products', '/admin/products/create',
            '/admin/services', '/admin/services/create', '/admin/materials',
            '/admin/hero-stories', '/admin/hero-stories/create', '/admin/company',
            '/admin/certifications', '/admin/certifications/create', '/admin/pages',
        ];
        foreach ($paths as $path) $this->get($path)->assertOk();

        $this->get('/admin/products/'.Product::first()->id.'/edit')->assertOk();
        $this->get('/admin/services/'.Service::first()->id.'/edit')->assertOk();
        $this->get('/admin/materials/'.Material::first()->id.'/edit')->assertOk()->assertSee('/images/');
        $this->get('/admin/hero-stories/'.HeroStory::first()->id.'/edit')->assertOk();
        $this->get('/admin/certifications/'.Certification::first()->id.'/edit')->assertOk()->assertSee('/images/credentials/');
        $this->get('/admin/pages/'.Page::first()->id.'/edit')->assertOk();
    }

    public function test_admin_create_update_and_delete_content_flows_work(): void
    {
        $this->actingAs($this->admin, 'admin');

        $this->post('/admin/products', ['name' => 'Test Product', 'image' => 'product-tpu.jpg', 'is_active' => '1'])
            ->assertRedirect('/admin/products');
        $product = Product::where('slug', 'test-product')->firstOrFail();
        $this->put('/admin/products/'.$product->id, ['name' => 'Updated Product', 'is_active' => '1'])
            ->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', ['id' => $product->id, 'slug' => 'updated-product']);
        $this->get('/')->assertOk()->assertSee('Updated Product');
        $this->get('/products/updated-product')->assertOk()->assertSee('data-page="product-updated-product"', false);
        $this->delete('/admin/products/'.$product->id)->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        $this->post('/admin/services', ['name' => 'Test Service', 'is_active' => '1'])->assertRedirect('/admin/services');
        $service = Service::where('slug', 'test-service')->firstOrFail();
        $this->put('/admin/services/'.$service->id, ['name' => 'Updated Service', 'is_active' => '1'])->assertRedirect('/admin/services');
        $this->delete('/admin/services/'.$service->id)->assertRedirect('/admin/services');

        $this->post('/admin/certifications', ['name' => 'Test Certificate', 'image' => 'grs.png', 'is_active' => '1'])
            ->assertRedirect('/admin/certifications');
        $certificate = Certification::where('name', 'Test Certificate')->firstOrFail();
        $this->put('/admin/certifications/'.$certificate->id, ['name' => 'Updated Certificate', 'is_active' => '1'])
            ->assertRedirect('/admin/certifications');
        $this->delete('/admin/certifications/'.$certificate->id)->assertRedirect('/admin/certifications');

        $this->post('/admin/hero-stories', ['label' => 'Test Story', 'is_active' => '1'])
            ->assertRedirect('/admin/hero-stories');
        $story = HeroStory::where('label', 'Test Story')->firstOrFail();
        $this->put('/admin/hero-stories/'.$story->id, ['label' => 'Updated Story', 'is_active' => '1'])
            ->assertRedirect('/admin/hero-stories');
        $this->delete('/admin/hero-stories/'.$story->id)->assertRedirect('/admin/hero-stories');
    }

    public function test_admin_updates_singletons_and_manages_enquiries(): void
    {
        $this->actingAs($this->admin, 'admin');

        $material = Material::firstOrFail();
        $this->put('/admin/materials/'.$material->id, ['name' => 'Updated Material'])
            ->assertRedirect('/admin/materials');
        $this->assertDatabaseHas('materials', ['id' => $material->id, 'name' => 'Updated Material']);

        $page = Page::firstOrFail();
        $this->put('/admin/pages/'.$page->id, ['title' => 'Updated SEO Title', 'is_active' => '1'])
            ->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Updated SEO Title']);

        $this->put('/admin/company', ['name' => 'Fibro Test', 'social_labels' => [], 'social_hrefs' => [], 'social_accessible' => []])
            ->assertRedirect('/admin/company');
        $this->assertDatabaseHas('company_settings', ['key' => 'name', 'value' => 'Fibro Test']);

        $enquiry = Enquiry::create(['name' => 'Buyer', 'email' => 'buyer@example.test', 'type' => 'project', 'message' => 'A complete textile project request.']);
        $this->get('/admin/enquiries/'.$enquiry->id)->assertOk();
        $this->assertNotNull($enquiry->fresh()->read_at);
        $this->patch('/admin/enquiries/'.$enquiry->id.'/toggle-read')->assertRedirect();
        $this->assertNull($enquiry->fresh()->read_at);
        $this->delete('/admin/enquiries/'.$enquiry->id)->assertRedirect('/admin/enquiries');
        $this->assertSoftDeleted('enquiries', ['id' => $enquiry->id]);
    }
    public function test_admin_images_upload_replace_display_and_validate(): void
    {
        Storage::fake('web');
        $this->actingAs($this->admin, 'admin');

        $this->post('/admin/products', [
            'name' => 'Uploaded Product', 'is_active' => '1',
            'image_file' => UploadedFile::fake()->image('product.jpg', 1200, 800),
        ])->assertRedirect('/admin/products');
        $product = Product::where('slug', 'uploaded-product')->firstOrFail();
        $firstPath = 'images/'.ltrim($product->image, '/');
        Storage::disk('web')->assertExists($firstPath);
        $this->get('/')->assertOk()->assertSee($product->image);

        $this->put('/admin/products/'.$product->id, [
            'name' => 'Uploaded Product', 'is_active' => '1', 'image' => $product->image,
            'image_file' => UploadedFile::fake()->image('replacement.webp', 1200, 800),
        ])->assertRedirect('/admin/products');
        Storage::disk('web')->assertMissing($firstPath);
        Storage::disk('web')->assertExists('images/'.ltrim($product->fresh()->image, '/'));

        $service = Service::firstOrFail();
        $this->put('/admin/services/'.$service->id, ['name' => $service->name, 'is_active' => '1', 'image' => $service->image, 'image_file' => UploadedFile::fake()->image('service.png')])->assertRedirect('/admin/services');
        Storage::disk('web')->assertExists('images/'.ltrim($service->fresh()->image, '/'));

        $material = Material::firstOrFail();
        $this->put('/admin/materials/'.$material->id, ['name' => $material->name, 'image' => $material->image, 'image_file' => UploadedFile::fake()->image('material.jpg')])->assertRedirect('/admin/materials');
        Storage::disk('web')->assertExists(ltrim($material->fresh()->image, '/'));

        $story = HeroStory::firstOrFail();
        $this->put('/admin/hero-stories/'.$story->id, ['label' => $story->label, 'is_active' => '1', 'image' => $story->image, 'image_file' => UploadedFile::fake()->image('hero.jpg')])->assertRedirect('/admin/hero-stories');
        Storage::disk('web')->assertExists(ltrim($story->fresh()->image, '/'));

        $certificate = Certification::firstOrFail();
        $this->put('/admin/certifications/'.$certificate->id, ['name' => $certificate->name, 'is_active' => '1', 'image' => $certificate->image, 'image_file' => UploadedFile::fake()->image('certificate.png')])->assertRedirect('/admin/certifications');
        Storage::disk('web')->assertExists('images/'.$certificate->fresh()->image);

        $this->post('/admin/products', ['name' => 'Invalid Upload', 'image_file' => UploadedFile::fake()->create('document.pdf', 20, 'application/pdf')])
            ->assertSessionHasErrors('image_file');
        $this->assertDatabaseMissing('products', ['slug' => 'invalid-upload']);
    }

    public function test_admin_email_and_password_can_be_set_from_environment_configuration(): void
    {
        config(['admin.seed_name' => 'Environment Admin', 'admin.seed_current_email' => 'admin@example.test', 'admin.seed_email' => 'environment@example.test', 'admin.seed_password' => 'First-Strong-Password-2026']);
        $this->seed(AdminUserSeeder::class);
        $admin = AdminUser::where('email', 'environment@example.test')->firstOrFail();
        $this->assertSame('Environment Admin', $admin->name);
        $this->assertTrue(Hash::check('First-Strong-Password-2026', $admin->password));

        config(['admin.seed_password' => 'Replacement-Strong-Password-2026']);
        $this->seed(AdminUserSeeder::class);
        $this->assertTrue(Hash::check('Replacement-Strong-Password-2026', $admin->fresh()->password));
        $this->assertDatabaseMissing('admin_users', ['email' => 'admin@example.test']);
        $this->assertDatabaseCount('admin_users', 1);
    }

}
