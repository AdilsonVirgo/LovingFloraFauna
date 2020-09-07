<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Instalacion;
use App\ReservaAlojamiento;
use App\Servicio;
use App\Gastronomia;

class Gastronomia extends Model {

    protected $fillable = [
        'name','ueb_id', 'capacidad','paxs','disponibilidad', 'activa', 'observaciones',
    ];

    public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

    public function ueb() {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }

    public function reservagastronomias() {
        return $this->hasMany('App\ReservaGastronomia');
        //hasOne
    }
}
