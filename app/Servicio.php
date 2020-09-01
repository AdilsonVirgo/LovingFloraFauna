<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cocodrilera;
use App\Reserva;
use App\ReservaCocodrilera;
use App\User;

class Servicio extends Model {

    protected $guarded = [];
    /* use Notifiable; */
    protected $fillable = [
        'name', 'watchable_type', 'watchable_id', 'capacidad', 'activa', 'observaciones',
    ];

    /* protected $casts = [
      'fecha' => 'date:Y-m-d',
      ]; */

    public function watchable() {
        return $this->morphTo();
    }

}
