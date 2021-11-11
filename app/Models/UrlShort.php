<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
    protected $fillable = [
        'url',
        'short'
    ];

}
