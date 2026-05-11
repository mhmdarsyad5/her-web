<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\SeoComposer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerRenderHook(
                'panels::head.start',
                fn() => view('filament.favicon')
            );
        });

        Filament::serving(function () {
            Filament::registerRenderHook(
                'panels::auth.login.form.before',
                fn() => view('filament.components.login-brand')
            );
        });

        Filament::serving(function () {
            $siteName = strip_tags(
                setting('site_name', config('app.name'))
            );
            Filament::getCurrentPanel()?->brandName($siteName);
        });

        View::share('siteName', strip_tags(setting('site_name', config('app.name'))));

        View::composer('frontend.*', SeoComposer::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
