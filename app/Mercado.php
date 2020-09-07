<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Mercado extends Model
{
     protected $fillable = [
        'name', 'activa', 'observaciones',
    ];
      public function reserva()
    {
        return $this->belongsTo('App\ReservaAlojamiento');
    }
}
