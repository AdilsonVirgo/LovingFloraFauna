<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reserva;
use App\ReservaSafari;
use App\Safari;
use App\User;
use App\Mercado;
use App\Notifications\NotificacionReserva;

class ReservaSafari extends Model {

    protected $fillable = [
        'name',
        'safari_id',
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

    public function safari() {
        return $this->belongsTo('App\Safari');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
