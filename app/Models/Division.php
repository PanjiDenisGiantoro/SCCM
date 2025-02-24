<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'divisions';
    protected $guarded = [];
    public function organizations()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');

    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function managers()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

}
