<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
