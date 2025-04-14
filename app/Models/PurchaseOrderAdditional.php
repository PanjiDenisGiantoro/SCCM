<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderAdditional extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_order_additionals';
    public function wos()
    {
        return $this->hasOne(Work_orders::class, 'id', 'wo_id');
    }
    public function accounts()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
    public function charge_account()
    {
        return $this->hasOne(ChargeDepartment::class, 'id', 'charge_department');
    }

    public function facilities()
    {
        return $this->belongsTo(Facility::class);
    }
}
