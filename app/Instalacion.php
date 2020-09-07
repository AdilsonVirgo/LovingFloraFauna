<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReservaAlojamiento;
use App\Alojamiento;

class Instalacion extends Model
{
    
    protected $fillable = [
        'name', 'activa','boolaloj', 'observaciones',
    ];
    
     public function alojamiento()
    {
        return $this->hasOne('App\Alojamiento');
        //hasOne
    }

}
