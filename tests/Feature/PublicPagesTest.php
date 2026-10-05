<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_public_pages_have_prerendered_content_and_correct_canonicals(): void
    {
        $pages = json_decode(file_get_contents(resource_path('data/pages.json')), true, 512, JSON_THROW_ON_ERROR);
        $this->assertCount(24, $pages);
        foreach ($pages as $page) {
            $response = $this->get($page['path'])->assertOk();
            $response->assertSee('<link rel="canonical" href="'.url($page['path']).'">', false);
            $response->assertSee('<meta name="description"', false);
            $response->assertSee('<meta property="og:title"', false);
            $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
            $response->assertSee('<script type="application/ld+json">', false);
            if ($page['id'] !== 'home') {
                $response->assertSee('data-page="'.$page['id'].'"', false);
                $response->assertSee($page['title']);
            }
            $response->assertSee('fibrolaminates@gmail.com');
        }
        $sitemap = $this->get('/sitemap.xml')->assertOk()->assertDontSee('/blog');
        foreach ($pages as $page) {
            $sitemap->assertSee('<loc>'.url($page['path']).'</loc>', false);
        }
        $this->get('/robots.txt')->assertOk()
            ->assertSee(url('/sitemap.xml'))
            ->assertSee('Disallow: /admin')
            ->assertSee('Disallow: /enquiries');
    }

    public function test_missing_and_excluded_pages_return_branded_404(): void
    {
        foreach (['/news', '/careers', '/downloads', '/products/missing', '/services/missing', '/blog', '/blog/prepare-your-textile-brief', '/blog/planning-a-digital-printing-enquiry'] as $path) {
            $this->get($path)->assertNotFound()->assertSee('FIBRO / 404')->assertSee('content="noindex"', false);
        }
    }
}
