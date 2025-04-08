<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'parts';

    public function boms()
    {
        return $this->hasMany(Boms::class, 'id_asset')
            ->whereNotNull('quantity')
            ->where('model', 'App\Models\Boms')
            ->selectRaw('MIN(id) as id, id_asset, id_bom, MIN(quantity) as quantity, model, MIN(created_at) as created_at, MIN(updated_at) as updated_at, name')
            ->groupBy('name', 'id_asset', 'id_bom', 'model');
    }

    public function categories()
    {
        return $this->belongsTo(AssetCategory::class, 'category', 'id');
    }
}
