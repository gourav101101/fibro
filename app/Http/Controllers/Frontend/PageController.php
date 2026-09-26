<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Support\PageMetadata;

class PageController extends Controller
{
    private function pages(): Collection
    {
        return PageMetadata::all();
    }

    public function show(Request $request): View
    {
        $page = $this->pages()->firstWhere('path', '/'.$request->path());
        abort_unless($page && $page['is_active'], 404);
        return view('frontend.pages.inside', compact('page'));
    }

    public function sitemap(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($this->pages() as $page) {
            if (! $page['is_active']) continue;
            $xml .= '<url><loc>'.htmlspecialchars(url($page['path']), ENT_XML1, 'UTF-8').'</loc></url>';
        }
        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
