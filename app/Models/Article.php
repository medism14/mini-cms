<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Text;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Page;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'page_id'
    ];

    public function page () {
        return $this->belongsTo(Page::class);
    }

    public function texts () {
        return $this->hasOne(Text::class);
    }

    public function images () {
        return $this->hasOne(Image::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }

}
