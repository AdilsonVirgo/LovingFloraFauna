<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaObs extends Model
{
     protected $fillable = [
        'name',
        'obs_id',
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
      
    public function observacion() {
        return $this->belongsTo('App\Obs');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }

}
