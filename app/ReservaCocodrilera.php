<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cocodrilera;
use App\Reserva;
use App\Servicio;
use App\User;

class ReservaCocodrilera extends Model {

    protected $fillable = [
        'name',
        'cocodrilera_id',
        'mercado_id',
        'total_pax',
        'plan',
        'fecha_entrada',
        'fecha_salida',
        'activa',
        'observaciones',];

    /*  protected $casts = [
      'fecha_entrada' => 'date',
      'fecha_salida' => 'date',
      ];
     */

    public function cocodrilera() {
        return $this->belongsTo('App\Cocodrilera');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
