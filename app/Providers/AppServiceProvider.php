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

        // Register Filament FileUpload WebP Optimization Macro
        \Filament\Forms\Components\FileUpload::macro('optimizeToWebp', function (int $maxWidth = 1200, int $quality = 80) {
            return $this
                ->image()
                ->saveUploadedFileUsing(function ($file, $state, $component) use ($maxWidth, $quality) {
                    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file */
                    $filePath = $file->getRealPath();

                    $manager = \Intervention\Image\ImageManager::gd();
                    $image = $manager->read($filePath);

                    $image->orient();

                    if ($image->width() > $maxWidth) {
                        $image->scale(width: $maxWidth);
                    }

                    $webpData = $image->toWebp($quality)->toString();
                    $filename = \Illuminate\Support\Str::random(40).'.webp';

                    $directory = $component->getDirectory() ?? 'uploads';
                    $disk = $component->getDiskName() ?? 'public';
                    $targetPath = $directory.'/'.$filename;

                    \Illuminate\Support\Facades\Storage::disk($disk)->put($targetPath, $webpData);

                    return $targetPath;
                });
        });
    }
}
