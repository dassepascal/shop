<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRange
 */
class Range extends Model
{
    protected $fillable = [ 'max', ];
public $timestamps = false;
}
