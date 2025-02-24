<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'organizations';

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

}
