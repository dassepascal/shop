<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{

    use HasFactory;
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
