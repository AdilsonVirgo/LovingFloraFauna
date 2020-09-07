<?php

namespace App;

use App\Provincia;
use App\ReservaSafari;
use App\Servicio;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Database\Eloquent\Model;

class Safari extends Model
{
    protected $fillable = [
       'name','ueb_id','capacidad','paxs','disponibilidad', 'activa', 'observaciones',
    ];

   public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

    public function ueb() {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }

    public function reservasafaris() {
        return $this->hasMany('App\ReservaSafari');
        //hasOne
    }
}
