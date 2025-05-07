<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqArticle extends Model
{
    use SoftDeletes;

    public $table = 'faq_articles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'full_text',
        'short_text',
        'views_count',
        'category_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(FaqTag::class);
    }
}
