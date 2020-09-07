<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dispolist extends Model
{
   protected $fillable = [
        'name', 'servicio_id','diarioreal', 'disponibilidad','fecha',
    ];
   /* protected $casts = [
        'fecha' => 'date',
    ];*/
    
    public function servicio() {
        return $this->belongsTo('App\Servicio');
    }
}
