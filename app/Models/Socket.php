<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socket extends Model
{
    protected $table = 'sockets';
    protected $guarded = [];
    public function errorLogs() {
        return $this->hasMany(SocketErrorLog::class);
    }
    public function alarms()
    {
        return $this->hasOne(AlarmSensor::class, 'id_socket', 'id');
    }


}
