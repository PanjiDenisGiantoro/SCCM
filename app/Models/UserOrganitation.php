<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganitation extends Model
{
    use HasFactory;

    protected $table = 'user_organitations';
    protected $guarded = [];

    public function organizations()
    {
        return $this->belongsTo(Organization::class);
    }
}
