<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping', 'tax', 'user_id', 'state_id', 'payment', 'reference', 'pick', 'total',
    ];
}
