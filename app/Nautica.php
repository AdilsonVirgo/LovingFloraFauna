<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Nautica;
use App\ReservaNautica;
use App\Reserva;
use App\Servicio;

class Nautica extends Model
{
    protected $fillable = [
       'name','ueb_id','capacidad','paxs','disponibilidad','activa', 'observaciones',
    ];
    public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

    public function ueb() {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }

    public function reservanauticas() {
        return $this->hasMany('App\ReservaNautica');
        //hasOne
    }
}
