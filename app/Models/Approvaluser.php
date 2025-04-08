<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvaluser extends Model
{
    protected $guarded = [];
    protected $table = 'approvaluser';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
