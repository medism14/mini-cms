<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Site;
use App\Models\Menu;
use App\Models\Article;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'site_id'
    ];

    public function site () {
        return $this->belongsTo(Site::class);
    }

    public function articles () {
        return $this->hasMany(Article::class);
    }

}
