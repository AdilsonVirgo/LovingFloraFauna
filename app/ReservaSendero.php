<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReservaSendero;
use App\Reserva;
use App\Sendero;
use App\Servicio;

class ReservaSendero extends Model {

    protected $fillable = [
        'name',
        'sendero_id',
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

    public function sendero() {
        return $this->belongsTo('App\Sendero');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
