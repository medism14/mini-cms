<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Page;
use App\Models\Menu;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'font_color',
        'background_color',
        'section_color',
        'user_id',
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function menu () {
        return $this->hasOne(Menu::class);
    }

    public function pages () {
        return $this->hasMany(Page::class);
    }
}
