<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use \App\Traits\LogsModelActivity;
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'slug',
        'is_active',
        'sort_order',
        'name_id',
        'description_id',
        'tagline',
        'product_type',
        'energy_type',
        'lift_height',
        'load_capacity',
        'price',
        'sale_price',
        'images',
        'specifications',
    ];

    /**
     * Cast attributes.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'specifications' => 'array',
    ];

    /**
     * Auto-generate slug from Indonesian name.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name_id);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name_id')) {
                $product->slug = Str::slug($product->name_id);
            }
        });
    }

    /**
     * Get thumbnail (first image).
     */
    public function getThumbnailAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    /**
     * Get final price (sale or normal).
     */
    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    /**
     * Get product name (alias for name_id for easier access)
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name_id'] ?? null;
    }

    /**
     * Get product description (alias for description_id for easier access)
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description_id'] ?? null;
    }

    /**
     * Set product name (map to name_id field)
     */
    public function setNameAttribute(?string $value): void
    {
        $this->attributes['name_id'] = $value;
    }

    /**
     * Set product description (map to description_id field)
     */
    public function setDescriptionAttribute(?string $value): void
    {
        $this->attributes['description_id'] = $value;
    }
}
