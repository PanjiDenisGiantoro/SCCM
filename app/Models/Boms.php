<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boms extends Model
{
    protected $table = 'boms_managers';
    protected $guarded = [];

    public function parts()
    {
        return $this->hasMany(Part::class, 'id', 'id_asset');
    }
    public function facilities()
    {
        return $this->hasOne(Facility::class, 'id', 'id_bom');
    }
}
