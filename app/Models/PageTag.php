<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTag extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'seo_title',
        'meta_description',
        'meta_keywords',
    ];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_tag', 'page_tag_id', 'page_id');
    }
}
