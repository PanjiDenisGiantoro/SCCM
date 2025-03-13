<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocketErrorLog extends Model
{

    protected $table = 'socket_error_logs';
    protected $guarded = [];
    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}
