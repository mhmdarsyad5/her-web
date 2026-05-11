<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_tag', 'page_tag_id', 'page_id');
    }
}
