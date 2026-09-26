<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Collection;

class PageMetadata
{
    public static function all(): Collection
    {
        $pages = collect(json_decode(
            file_get_contents(resource_path('data/pages.json')),
            true,
            512,
            JSON_THROW_ON_ERROR
        ))->reject(fn (array $page) => in_array($page['type'] ?? null, ['product', 'service'], true));

        if (CmsDatabase::hasTable('products')) {
            $productPages = Product::query()->where('is_active', true)->orderBy('sort_order')->get()->map(fn (Product $product) => [
                'id' => 'product-'.$product->slug,
                'path' => '/products/'.$product->slug,
                'title' => $product->name,
                'description' => $product->text,
                'image' => $product->image,
                'type' => 'product',
                'slug' => $product->slug,
            ]);
            $servicePages = Service::query()->where('is_active', true)->orderBy('sort_order')->get()->map(fn (Service $service) => [
                'id' => 'service-'.$service->slug,
                'path' => '/services/'.$service->slug,
                'title' => $service->name,
                'description' => $service->text,
                'image' => $service->image,
                'type' => 'service',
                'slug' => $service->slug,
            ]);
            $pages = $pages->concat($productPages)->concat($servicePages);
        } else {
            $fallback = collect(json_decode(file_get_contents(resource_path('data/pages.json')), true, 512, JSON_THROW_ON_ERROR));
            $pages = $pages->concat($fallback->filter(fn (array $page) => in_array($page['type'] ?? null, ['product', 'service'], true)));
        }

        $overrides = CmsDatabase::hasTable('pages') ? Page::query()->get()->keyBy('page_key') : collect();

        return $pages->values()->map(function (array $page) use ($overrides): array {
            $override = $overrides->get($page['id']);
            if (! $override) {
                return $page + ['seo_title' => $page['title'], 'seo_description' => $page['description'] ?? null, 'is_active' => true, 'updated_at' => null];
            }
            return $page + [
                'seo_title' => $override->meta_title ?: $override->title ?: $page['title'],
                'seo_description' => $override->meta_description ?: $override->description ?: ($page['description'] ?? null),
                'is_active' => $override->is_active,
                'updated_at' => $override->updated_at?->toAtomString(),
            ] + ($override->og_image ? ['seo_image' => $override->og_image] : []);
        });
    }

    public static function findByPath(string $path): ?array
    {
        return self::all()->firstWhere('path', $path);
    }
}
