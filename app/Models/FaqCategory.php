<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*public function articles()
    {
        return $this->hasMany(Article::class);
    }
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }*/

    public function faqQuestions()
    {
        return $this->hasMany(FaqQuestion::class, 'category_id', 'id');
    }
}
