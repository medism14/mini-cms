<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;

class Text extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'article_id'
    ];

    public function article () {
        return $this->belongsTo(Article::class);
    }
}
