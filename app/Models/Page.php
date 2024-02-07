<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Site;
use App\Models\Menu;
use App\Models\Comment;
use App\Models\Article;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'site_id'
    ];

    public function site () {
        return $this->belongsTo(Site::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }

    public function articles () {
        return $this->hasMany(Article::class);
    }
}