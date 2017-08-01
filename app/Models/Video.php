<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'setting_id', 'name', 'folder', 'original_file_name', 'progress', 'extension', 'dash_variants', 'hash', 'status',
    ];

    protected $casts = [
        'dash_variants' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function setting()
    {
        return $this->hasOne('App\Models\VideoSettings', 'id', 'setting_id');
    }

}