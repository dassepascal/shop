<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'indice',
    ];

    public $timestamps = false;
}
