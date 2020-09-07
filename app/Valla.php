<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valla extends Model
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

    public function reservavallas() {
        return $this->hasMany('App\ReservaValla');
        //hasOne
    }
}
