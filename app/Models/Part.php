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
    public function receiptbodies()
    {
        return $this->hasMany(ReceiptBody::class, 'part_id', 'id');
    }
    public function purchasebodies()
    {
        return $this->hasMany(PurchaseOrderBodies::class, 'part_id', 'id');
    }
    public function accounts()
    {
        return $this->hasOne(Account::class, 'id', 'id_account');
    }
    public function charge()
    {
        return $this->hasOne(ChargeDepartment::class, 'id', 'id_charge');
    }
    public function warranties()
    {
        return $this->hasMany(Warranties::class, 'part_id', 'id');

    }

}
