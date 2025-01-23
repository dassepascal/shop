<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'tax',
    ];
    
    public $timestamps = false;
}
