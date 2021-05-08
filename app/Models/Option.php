<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillables = [
        "key",
        "value",
        "default"
    ];

    public $timestamps = false;
}
