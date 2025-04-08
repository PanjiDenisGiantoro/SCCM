<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $guarded = [];

    public function receipt_body()
    {
        return $this->hasMany(ReceiptBody::class, 'receipt_id');

    }
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');

    }
    public function pos()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_number');

    }

}
