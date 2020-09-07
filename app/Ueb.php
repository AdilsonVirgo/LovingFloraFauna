<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Ueb extends Model {

    protected $fillable = [
        'name', 'provincia_id', 'activa','observaciones',
    ];

    public function provincia() {
        return $this->belongsTo('App\Provincia');
    }
    public function reserva() {
        return $this->belongsTo('App\Reserva');
    }

}
