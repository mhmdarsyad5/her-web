<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'page',
        'meta_title',
        'meta_description',
        'meta_keywords',
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
