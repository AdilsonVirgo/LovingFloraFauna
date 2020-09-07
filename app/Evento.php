<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Instalacion;
use App\ReservaEvento;
use App\Reserva;
use App\Servicio;

class Evento extends Model
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

    public function reservaeventos() {
        return $this->hasMany('App\ReservaEvento');
        //hasOne
    }
}
