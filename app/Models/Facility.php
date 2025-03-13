<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $guarded = [];
    protected $table = 'facilities';

    public function categories()
    {
        return $this->hasOne(AssetCategory::class, 'id', 'category');
    }
    public function parent()
    {
        return $this->belongsTo(Facility::class, 'parent_id');
    }

    // Relasi ke Child
    public function children()
    {
        return $this->hasMany(Facility::class, 'parent_id');
    }
}
