<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $guarded = [];
    protected $table = 'equipments';
    public function parent()
    {
        return $this->belongsTo(Equipment::class, 'parent_id');
    }

    // Relasi ke Child
    public function children()
    {
        return $this->hasMany(Equipment::class, 'parent_id');
    }
}
