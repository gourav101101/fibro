<?php

use App\Http\Controllers\Frontend\EnquiryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/enquiries', [EnquiryController::class, 'store'])
    ->middleware('throttle:5,1')->name('enquiries.store');

foreach (['about', 'products', 'services', 'technology', 'contact', 'sustainability', 'manufacturing-quality', 'circular-textiles'] as $page) {
    Route::get('/'.$page, [PageController::class, 'show'])->name($page);
}
Route::get('/{section}/{slug}', [PageController::class, 'show'])
    ->whereIn('section', ['products', 'services'])->name('page.detail');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', fn () => response(
    "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /enquiries\nSitemap: ".url('/sitemap.xml')."\n",
    200,
    ['Content-Type' => 'text/plain; charset=UTF-8']
));
