<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colissimo extends Model
{
    protected $fillable = [
        'price', 'country_id', 'range_id',
    ];
    
    public $timestamps = false;

    public function country(): BelongsTo
{
    return $this->belongsTo(Country::class);
}
}
