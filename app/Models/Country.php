<?php

namespace App\Models;

use App\Models\Range;
use App\Models\Address;
use App\Models\OrderAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    protected $fillable = [
        'name', 'tax',
    ];
    
    public $timestamps = false;

    public function ranges(): BelongsToMany
{
    return $this->belongsToMany(Range::class, 'colissimos')->withPivot('id', 'price');
}

public function addresses(): HasMany
{
    return $this->hasMany(Address::class);
}

public function order_addresses(): HasMany
{
    return $this->hasMany(OrderAddress::class);
}
}
