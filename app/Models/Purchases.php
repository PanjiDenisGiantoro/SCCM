<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $table = 'purchases';
    protected $guarded = [];


    public function purchaseAdditional()
    {
        return $this->hasOne(PurchaseAdditional::class, 'purchase_id');
    }

    public function purchaseBodies()
    {
        return $this->hasMany(PurchaseBodies::class, 'purchase_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
