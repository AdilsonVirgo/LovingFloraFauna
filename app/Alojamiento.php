<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Instalacion;
use App\Ueb;
use App\ReservaAlojamiento;
use App\Reserva;
use App\Servicio;

class Alojamiento extends Model
{
    protected $fillable = [
        'name','ueb_id','capacidad','paxs','disponibilidad','sencilla','doble','triple','cuadruple',
        'albergue','activa', 'observaciones',
    ];
    public function ueb()
    {
        return $this->belongsTo('App\Ueb');
        //hasOne
    }
    public function reservaalojamientos()
    {
        return $this->hasMany('App\ReservaAlojamiento');
        //hasOne
    }
    
    public function servicio(){
       return $this->morphOne('App\Servicio','watchable');
    }
    
    
}
