<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function pages()
    {
        return $this->hasMany(Page::class, 'category_id');
    }
}
