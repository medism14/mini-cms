<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Page;
use App\Models\Article;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'content',
        'page_id'
    ];

    public function page () {
        return $this->belongsTo(Page::class);
    }

    public function articles () {
        return $this->hasMany(Article::class);
    }
    
}
