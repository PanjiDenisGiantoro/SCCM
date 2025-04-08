<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    protected $guarded = [];
    protected $table = 'tools';

    public function parent()
    {
        return $this->belongsTo(Tools::class, 'parent_id');
    }

    // Relasi ke Child
    public function children()
    {
        return $this->hasMany(Tools::class, 'parent_id');
    }
}
