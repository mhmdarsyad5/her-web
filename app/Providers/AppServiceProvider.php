<?php

namespace App\Providers;

use App\Http\View\Composers\SeoComposer;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        Filament::serving(function () {
            Filament::registerRenderHook(
                'panels::head.start',
                fn () => view('filament.favicon')
            );
        });

        Filament::serving(function () {
            Filament::registerRenderHook(
                'panels::auth.login.form.before',
                fn () => view('filament.components.login-brand')
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
