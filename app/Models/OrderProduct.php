<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOrderProduct
 */
class OrderProduct extends Model
{
    protected $fillable = [
        'name', 'total_price_gross', 'quantity',
    ];
}
