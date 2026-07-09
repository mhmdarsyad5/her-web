<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| SETTINGS CACHE (ALL)
|--------------------------------------------------------------------------
| - Semua setting di-load sekali
| - Disimpan forever di cache
| - Key => value
*/

if (! function_exists('settings_all')) {
    function settings_all(): array
    {
        return Cache::rememberForever('settings.all', function () {
            return DB::table('settings')
                ->pluck('value', 'key')
                ->toArray();
        });
    }
}

/*
|--------------------------------------------------------------------------
| SETTING HELPER
|--------------------------------------------------------------------------
*/

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        $settings = settings_all();

        if (! array_key_exists($key, $settings)) {
            return $default;
        }

        $value = $settings[$key];

        if (blank($value)) {
            return $default;
        }

        /*
         * =========================
         * ARRAY LANGSUNG
         * =========================
         */
        if (is_array($value)) {
            return resolveSettingArray($value, $default);
        }

        /*
         * =========================
         * STRING → JSON?
         * =========================
         */
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (is_array($decoded)) {
                    return resolveSettingArray($decoded, $default);
                }
                return $decoded;
            }

            // Plain string
            return $value;
        }

        return $default;
    }
}

/*
|--------------------------------------------------------------------------
| RESOLVE ARRAY SETTING
|--------------------------------------------------------------------------
*/

if (! function_exists('resolveSettingArray')) {
    function resolveSettingArray(array $value, mixed $default = null): mixed
    {
        /*
         * =========================
         * ACTIVE TOGGLE CHECK
         * =========================
         */
        if (array_key_exists('is_active', $value) && ! $value['is_active']) {
            return null;
        }

        /*
         * =========================
         * BOOLEAN / TOGGLE VALUE
         * =========================
         */
        if (array_key_exists('boolean_value', $value)) {
            return (bool) $value['boolean_value'];
        }

        /*
         * =========================
         * FILE UPLOAD (Filament)
         * =========================
         */
        if (! empty($value['path'])) {
            return $value['path'];
        }

        /*
         * =========================
         * COLOR VALUE
         * =========================
         */
        if (! empty($value['color'])) {
            return $value['color'];
        }

        /*
         * =========================
         * CONTENT VALUE (ID ONLY)
         * =========================
         */
        return $value['id'] ?? $default;
    }
}

if (! function_exists('setting_embed_src')) {
    function setting_embed_src(string $key, mixed $default = null): mixed
    {
        $value = setting($key, $default);

        if (! is_string($value)) {
            return $value;
        }

        $value = trim(strip_tags($value));

        if (preg_match('/src=(?:"|\')(?P<url>[^"\']+)(?:"|\')/i', $value, $matches)) {
            return $matches['url'];
        }

        return $value;
    }
}

if (! function_exists('setting_src')) {
    function setting_src(string $key, mixed $default = null): mixed
    {
        return setting_embed_src($key, $default);
    }
}

/*
|--------------------------------------------------------------------------
| SETTING URL (ASSET / IMAGE)
|--------------------------------------------------------------------------
| - Ada cache sendiri
| - Cocok buat logo, favicon, banner, dll
*/

if (! function_exists('setting_url')) {
    function setting_url(
        string $key,
        string $defaultAsset = 'assets-default/settings/logo.png'
    ): string {
        return Cache::rememberForever("settings.url.{$key}", function () use ($key, $defaultAsset) {
            $path = setting($key);

            if (is_string($path) && filled($path)) {
                return Storage::disk('public')->url($path);
            }

            return asset($defaultAsset);
        });
    }
}
