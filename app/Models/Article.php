<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    public function Wordpress(): BelongsTo
    {
        return $this->belongsTo(Wordpress::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'pivot_article_tag', 'article_id', 'tag_id');
    }
    
    public function category()
    {
        return $this->belongsToMany(Category::class, 'pivot_article_category', 'article_id', 'category_id');
    }
}
