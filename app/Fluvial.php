<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Provincia;

class Fluvial extends Model
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

    public function reservafluvials() {
        return $this->hasMany('App\ReservaFluvial');
        //hasOne
    }
}
