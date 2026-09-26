<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Support\PageMetadata;

class HomeController extends Controller
{
    public function index(): View
    {
        $page = PageMetadata::findByPath('/');
        abort_unless($page && $page['is_active'], 404);

        return view('frontend.pages.home', compact('page'));
    }
}
