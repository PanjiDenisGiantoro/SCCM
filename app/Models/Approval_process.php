<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval_process extends Model
{
    protected $table = 'approval_process';
    protected $primaryKey = 'process_id'; // Ubah sesuai dengan primary key yang ada di tabel

    protected $fillable = [
        'process_name',
        'required_approvals',
        'budget',
        'max_budget',
    ];
    public $timestamps = false;
}
