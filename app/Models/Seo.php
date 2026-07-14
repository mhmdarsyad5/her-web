<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'page',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected static function booted(): void
    {
        static::saving(function (Seo $seo) {
            $seo->page = strtolower($seo->page);
        });

        static::saved(function (Seo $seo) {
            \Illuminate\Support\Facades\Cache::forget('seo_'.$seo->page);
        });

        static::deleted(function (Seo $seo) {
            \Illuminate\Support\Facades\Cache::forget('seo_'.$seo->page);
        });
    }
}
