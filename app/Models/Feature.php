<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable=[
        'name'
    ];

    /**
     * The products that belong to the Feature
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'feature_product')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
