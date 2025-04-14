<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $guarded = [];
    public function purchases()
    {
        return $this->hasOne(Purchases::class, 'id', 'id_pr');

    }
    public function purchaseAdditional()
    {
        return $this->hasOne(PurchaseOrderAdditional::class, 'purchase_id');
    }

    public function purchaseBodies()
    {
        return $this->hasMany(PurchaseOrderBodies::class, 'purchase_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
}
