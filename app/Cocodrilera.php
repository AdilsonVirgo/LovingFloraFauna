<?php

namespace App;

use App\Servicio;
use App\Reserva;
use App\ReservaCocodrilera;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Cocodrilera extends Model {

    protected $fillable = [
        'name', 'ueb_id', 'capacidad', 'paxs', 'disponibilidad', 'provincia_id',
        'activa', 'observaciones',
    ];

    public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

}
