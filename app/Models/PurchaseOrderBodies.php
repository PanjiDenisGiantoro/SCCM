<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderBodies extends Model
{
    protected $table = 'purchase_order_bodies';
    protected $guarded = [];
    public function assets()
    {
        return $this->morphTo();
    }

    public function part()
    {
        return $this->hasOne(Part::class, 'id', 'part_id');
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class, 'id', 'part_id');
    }

    public function tools()
    {
        return $this->hasOne(Tools::class, 'id', 'part_id');
    }
    public function facility()
    {
        return $this->hasOne(Facility::class, 'id', 'part_id');
    }

    public function getAsset()
    {
        if ($this->model === 'part') {
            return $this->part;
        } elseif ($this->model === 'equipment') {
            return $this->equipment;
        } elseif ($this->model === 'tool') {
            return $this->tools;
        }elseif ($this->model === 'facility') {
            return $this->facility;
        }
        return null;
    }
    public function getpurchaseorder()
    {
        return $this->hasOne(PurchaseOrder::class, 'id', 'purchase_id');
    }


}
