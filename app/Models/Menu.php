<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'site_id'
    ];

    public function site () {
        return $this->belongsTo(Site::class);
    }
    
}
