<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'category_id',
        'status',
        'seo_title',
        'meta_description',
        'meta_keywords',
        'publish_at',
        'created_by',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    /**
     * ======================
     * RELATION
     * ======================
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PageCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PageTag::class, 'page_tag', 'page_id', 'page_tag_id');
    }
}
