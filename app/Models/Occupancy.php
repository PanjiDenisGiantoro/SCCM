<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    protected $guarded = [];
    protected $table = 'occupancies';
    protected $casts = [
        'facilities' => 'array',
    ];
}
