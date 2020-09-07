<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesca extends Model
{
    protected $fillable = [
        'name','ueb_id','capacidad','paxs','disponibilidad','lugar','embarcacion','observaciones',
    ];
   
   public function servicio() {
        return $this->morphOne('App\Servicio', 'watchable');
    }

    public function ueb() {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }

    public function reservapescas() {
        return $this->hasMany('App\ReservaPesca');
        //hasOne
    }
}
