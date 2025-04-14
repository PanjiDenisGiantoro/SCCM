<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeDepartment extends Model
{
    protected $guarded = [];
    protected $table = 'charge_departments';
    public function facility()
    {
        return $this->hasOne(Facility::class, 'id', 'id_facility');

    }
}
