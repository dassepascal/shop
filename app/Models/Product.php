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
    protected function casts(): array
    {
        return [
            'promotion_start_date' => 'datetime:Y-m-d',
            'promotion_end_date' => 'datetime:Y-m-d',
        ];
    }
}
