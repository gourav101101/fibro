<?php

namespace App\Support;

use App\Models\Certification;
use App\Models\CompanySetting;
use App\Models\HeroStory;
use App\Models\Material;
use App\Models\Product;
use App\Models\Service;

class CmsContent
{
    public static function all(): array
    {
        if (! CmsDatabase::hasTable('products')) {
            return [];
        }

        $company = CompanySetting::query()->pluck('value', 'key')->all();
        if (isset($company['socialLinks'])) {
            $company['socialLinks'] = json_decode($company['socialLinks'], true) ?: [];
        }

        return [
            'company' => $company,
            'products' => Product::query()->where('is_active', true)->orderBy('sort_order')->get()->values()->map(fn ($item) => array_merge($item->toArray(), [
                'image' => preg_replace('#^/?(?:images/)+#', '', str_replace('\\', '/', $item->image ?? '')),
            ])),
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get()->values()->map(fn ($item) => array_merge($item->toArray(), [
                'image' => preg_replace('#^/?(?:images/)+#', '', str_replace('\\', '/', $item->image ?? '')),
            ])),
            'materials' => Material::query()->orderBy('sort_order')->get()->values()->map(fn ($item) => [
                'id' => $item->key,
                'name' => $item->name,
                'category' => $item->category,
                'image' => $item->image,
                'alt' => $item->alt,
                'use' => $item->use,
                'description' => $item->description,
                'details' => $item->details,
                'attributes' => is_array($item->attributes) ? implode(' · ', $item->attributes) : $item->attributes,
            ]),
            'heroStories' => HeroStory::query()->where('is_active', true)->orderBy('sort_order')->get()->values(),
            'certifications' => Certification::query()->where('is_active', true)->orderBy('sort_order')->get()->values()->map(fn ($item) => [
                'name' => $item->name,
                'image' => preg_replace('#^/?(?:images/)?credentials/#', '', str_replace('\\', '/', $item->image ?? '')),
                'category' => $item->category,
            ]),
        ];
    }
}
