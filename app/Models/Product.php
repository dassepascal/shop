<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'quantity', 'weight', 'active', 'quantity_alert', 'image', 'description',
    ];
}
