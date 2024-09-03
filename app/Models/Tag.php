<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;
    public function article()
    {
        return $this->belongsToMany(Article::class, 'pivot_article_tag', 'tag_id', 'article_id');
    }
    
    public function wp() : BelongsTo
    {
        return $this->belongsTo(Wordpress::class);
    }
}
