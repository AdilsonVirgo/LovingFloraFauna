<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Excursion extends Model
{
    public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

    public function ueb() {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }

    public function reservaexcursions() {
        return $this->hasMany('App\ReservaExcursion');
        //hasOne
    }
}
