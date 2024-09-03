<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    public function Wps() : BelongsTo 
    {
        return $this->belongsTo(Wordpress::class);
    }    
    
    public function articles() 
    {
        return $this->belongsToMany(Article::class, 'pivot_article_category', 'category_id', 'article_id');
    }

}
