<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Site;
use App\Models\Menu;
use App\Models\Comment;
use App\Models\Section;

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

    public function sections () {
        return $this->hasMany(Section::class);
    }
}
