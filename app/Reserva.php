<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Cocodrilera;
use App\Servicio;
use App\ReservaCocodrilera;
use App\User;

class Reserva extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'numero','name', 'ueb_id',
        'reservable_type',
        'reservable_id',
        'total_pax',
        'fecha_entrada',
        'fecha_salida',
        'nac_id',
        'activa',
        'observaciones',];
    
   /*  protected $casts = [
        'fecha_entrada' => 'date',
        'fecha_salida' => 'date',
    ];*/

    public function reservable() {
        return $this->morphTo();
    }

    public function servicios() {
        return $this->belongsToMany('App\Servicio')->withTimestamps();
    }

}
