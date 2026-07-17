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
        \Filament\Forms\Components\FileUpload::macro('optimizeToWebp', function (int $maxWidth = 1200, int $quality = 80, string $prefix = '', bool $isPurePrefix = false) {
            return $this
                ->image()
                ->saveUploadedFileUsing(function ($file, $state, $component) use ($maxWidth, $quality, $prefix, $isPurePrefix) {
                    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file */
                    $filePath = $file->getRealPath();
                    $disk = $component->getDiskName() ?? 'public';

                    // Tentukan direktori
                    $directory = $component->getDirectory() ?? 'uploads';
                    if (! $isPurePrefix) {
                        $directory = rtrim($directory, '/').'/'.date('Y/F');
                    } else {
                        $directory = rtrim($directory, '/');
                    }

                    // Siapkan nama slug asli dan string prefix
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $slugifiedName = \Illuminate\Support\Str::slug($originalName);
                    $prefixString = $prefix ? \Illuminate\Support\Str::slug($prefix).'-' : '';

                    try {
                        $manager = \Intervention\Image\ImageManager::gd();
                        $image = $manager->read($filePath);

                        $image->orient();

                        if ($image->width() > $maxWidth) {
                            $image->scale(width: $maxWidth);
                        }

                        $webpData = $image->toWebp($quality)->toString();

                        if ($isPurePrefix) {
                            if ($component->isMultiple()) {
                                // Cari nomor indeks urutan berikutnya
                                $existingFiles = \Illuminate\Support\Facades\Storage::disk($disk)->files($directory);
                                $pattern = '/^'.preg_quote($prefix, '/').'-(\d+)\.webp$/i';
                                $maxIndex = 0;
                                foreach ($existingFiles as $existingFile) {
                                    $basename = basename($existingFile);
                                    if (preg_match($pattern, $basename, $matches)) {
                                        $maxIndex = max($maxIndex, (int) $matches[1]);
                                    }
                                }
                                $nextIndex = $maxIndex + 1;
                                $filename = $prefix.'-'.$nextIndex.'.webp';
                            } else {
                                $filename = $prefix.'.webp';
                            }
                        } else {
                            $filename = $prefixString.$slugifiedName.'-'.time().'-'.\Illuminate\Support\Str::random(5).'.webp';
                        }

                        $targetPath = $directory.'/'.$filename;
                        \Illuminate\Support\Facades\Storage::disk($disk)->put($targetPath, $webpData);

                        return $targetPath;
                    } catch (\Throwable $e) {
                        // Log warning jika gagal decode (misal .heic dari iPhone)
                        \Illuminate\Support\Facades\Log::warning('Gagal kompresi WebP, menggunakan file asli: '.$e->getMessage());

                        // Fallback: simpan file asli dengan nama terstruktur
                        $extension = $file->getClientOriginalExtension();
                        if ($isPurePrefix) {
                            if ($component->isMultiple()) {
                                $existingFiles = \Illuminate\Support\Facades\Storage::disk($disk)->files($directory);
                                $pattern = '/^'.preg_quote($prefix, '/').'-(\d+)\.'.preg_quote($extension, '/').'$/i';
                                $maxIndex = 0;
                                foreach ($existingFiles as $existingFile) {
                                    $basename = basename($existingFile);
                                    if (preg_match($pattern, $basename, $matches)) {
                                        $maxIndex = max($maxIndex, (int) $matches[1]);
                                    }
                                }
                                $nextIndex = $maxIndex + 1;
                                $filename = $prefix.'-'.$nextIndex.'.'.$extension;
                            } else {
                                $filename = $prefix.'.'.$extension;
                            }
                        } else {
                            $filename = $prefixString.$slugifiedName.'-'.time().'-'.\Illuminate\Support\Str::random(5).'.'.$extension;
                        }

                        $targetPath = $directory.'/'.$filename;

                        return $file->storeAs($directory, $filename, $disk);
                    }
                });
        });
    }
}
