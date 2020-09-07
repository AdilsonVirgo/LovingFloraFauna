<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaEcuestre extends Model
{
    protected $fillable = [
        'name',
        'ecuestre_id',
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
     
    public function ecuestre() {
        return $this->belongsTo('App\Ecuestre');
    }

    public function mercado() {
        return $this->hasOne('App\Mercado');
    }

    public function reserva() {
        return $this->morphOne('App\Reserva', 'reservable');
    }
}
