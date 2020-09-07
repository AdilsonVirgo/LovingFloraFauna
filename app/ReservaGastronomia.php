<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reserva;
use App\ReservaSendero;
use App\Sendero;
use App\User;
use App\Mercado;
use App\Notifications\NotificacionReserva;

class ReservaGastronomia extends Model
{
    protected $fillable = [
        
        'name',
        'gastronomia_id',        
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
     
    public function gastronomia() {
        return $this->belongsTo('App\Gastronomia');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }
    
     public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }
    
}
