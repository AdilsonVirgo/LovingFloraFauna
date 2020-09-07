<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Alojamiento;
use App\Reserva;
use App\ReservaAlojamiento;
use App\Mercado;
use  App\User;
use App\Notifications\NotificacionReserva;

class ReservaAlojamiento extends Model {

    protected $fillable = [
        'name',
        'alojamiento_id',
        'mercado_id',
        'total_pax',
        'sencilla',
        'doble',
        'triple',
        'cuadruple',
        'albergue',
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
    public function alojamiento() {
        return $this->belongsTo('App\Alojamiento');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
