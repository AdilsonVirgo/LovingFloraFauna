<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaExcursion extends Model
{
     protected $fillable = [
        'name',
        'excursion_id',
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
      
    public function excursion() {
        return $this->belongsTo('App\Excursion');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
