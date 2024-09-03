<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wordpress extends Model
{
    use HasFactory;
    
    public function Article(): HasMany
    {
        return $this->hasMany(Article::class, 'wordpress_id');
    }

    public function Tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'wordpress_id');
    }
    
    public function Category(): HasMany
    {
        return $this->hasMany(Category::class, 'wordpress_id');
    }
}
