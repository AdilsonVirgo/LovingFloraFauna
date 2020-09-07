<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaPesca extends Model
{
    protected $fillable = [
        'name',
        'pesca_id',
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
     
    public function pesca() {
        return $this->belongsTo('App\Pesca');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }
}
