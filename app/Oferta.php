<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mercado;
use App\Instalacion;
use App\User;
use App\Reserva;
use App\Servicio;


class Oferta extends Model
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

    public function reservaofertas() {
        return $this->hasMany('App\ReservaOferta');
        //hasOne
    }
}
