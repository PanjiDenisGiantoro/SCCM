<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseBodies extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_bodies';


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
        } elseif ($this->model === 'tools') {
            return $this->tools;
        }elseif ($this->model === 'facility') {
            return $this->facility;
        }
        return null;
    }
}
