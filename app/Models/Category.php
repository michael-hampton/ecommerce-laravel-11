<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function hasGrandchildren(): bool
    {
        return ! empty($this->parent_id) && $this->subcategories()->count() > 0;
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttributes::class, 'category_id');
    }
}
