<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSettings extends Model
{
    protected $fillable = [
        'name', 'watermark', 'watermark_position', 'player_skin'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
