<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Alojamiento;
use App\Reserva;
use App\ReservaAlojamiento;
use App\ReservaEvento;
use App\Evento;
use App\Mercado;
use App\User;
use App\Notifications\NotificacionReserva;

class ReservaEvento extends Model {

    protected $fillable = [
        'name',
        'evento_id',
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
     
    public function evento() {
        return $this->belongsTo('App\Evento');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
