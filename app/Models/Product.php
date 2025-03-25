<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'weight',
        'active',
        'quantity_alert',
        'image',
        'description',
        'promotion_price',
        'promotion_start_date',
        'promotion_end_date',
    ];


    /**
     * Get the features associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_product')
                    ->withPivot('value')
                    ->withTimestamps();
    }
    protected function casts(): array
    {
        return [
            'promotion_start_date' => 'datetime:Y-m-d',
            'promotion_end_date' => 'datetime:Y-m-d',
        ];
    }
}
