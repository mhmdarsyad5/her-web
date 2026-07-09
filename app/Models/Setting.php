<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'category',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    protected static function cacheKey(string $key): string
    {
        return "setting_{$key}";
    }

    protected static function booted(): void
    {
        $flushAll = function (string $key = null) {
            cache()->forget('settings.all');

            if ($key) {
                cache()->forget(self::cacheKey($key));
            }

            $keys = ['logo', 'logo_light', 'logo_dark', 'favicon', 'og_image'];
            foreach ($keys as $urlKey) {
                cache()->forget("settings.url.{$urlKey}");
            }
        };

        static::deleting(function (Setting $setting) use (&$flushAll) {

            if (in_array($setting->key, [
                'primary_color',
                'warning_color',
            ])) {

                Notification::make()
                    ->title('Aksi Ditolak')
                    ->body('Setting ini bersifat sistem dan tidak boleh dihapus.')
                    ->danger()
                    ->send();

                return false;
            }

            $flushAll($setting->key);
        });

        static::saved(function (Setting $setting) use (&$flushAll) {
            $flushAll($setting->key);
        });
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public static function get(string $key, $default = null): mixed
    {
        return cache()->rememberForever(
            self::cacheKey($key),
            fn () => static::where('key', $key)->value('value') ?? $default
        );
    }

    public static function set(
        string $key,
        $value,
        string $type = 'text',
        string $category = 'general'
    ): void {
        $normalizedValue = match ($type) {
            'text' => is_array($value)
                ? $value
                : ['id' => $value],

            'image', 'video' => is_array($value)
                ? $value
                : ['path' => $value],

            'color' => is_array($value)
                ? $value
                : ['color' => $value],

            default => $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            [
                'value'    => $normalizedValue,
                'type'     => $type,
                'category' => $category,
            ]
        );

        cache()->forget(self::cacheKey($key));
    }

    public static function text(string $key, $default = null): mixed
    {
        $value = static::get($key, []);

        return is_array($value)
            ? ($value['id'] ?? $default)
            : $default;
    }

    public static function file(string $key, $default = null): mixed
    {
        $value = static::get($key, []);

        return is_array($value)
            ? ($value['path'] ?? $default)
            : $default;
    }

    public static function color(string $key, $default = null): mixed
    {
        $value = static::get($key, []);

        if (is_string($value)) {
            return $value;
        }

        return is_array($value)
            ? ($value['color'] ?? $default)
            : $default;
    }
}
