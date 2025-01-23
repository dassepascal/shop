<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelsColissimo extends Model
{
    protected $fillable = [
        'price', 'country_id', 'range_id',
    ];
    
    public $timestamps = false;
}
