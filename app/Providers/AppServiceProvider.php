<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Support\CmsContent;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($path = config('fibro.public_path')) {
            $this->app->usePublicPath($path);
        }
    }

    public function boot(): void
    {
        View::composer('frontend.*', fn ($view) => $view->with('cmsContent', CmsContent::all()));
    }
}
