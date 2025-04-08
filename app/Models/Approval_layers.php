<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval_layers extends Model
{
    protected $primaryKey = 'layer_id';
    protected $fillable = [
        'layer_id',
        'process_id',
        'sequence_order',
        'role_id',
    ];
    protected $table = 'approval_layers';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'role_id');

    }
}
