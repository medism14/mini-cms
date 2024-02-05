<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Text;
use App\Models\Image;
use App\Models\Section;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'section_id'
    ];

    public function section () {
        return $this->belongsTo(Section::class);
    }

    public function texts () {
        return $this->hasOne(Text::class);
    }

    public function images () {
        return $this->hasOne(Image::class);
    }

}
