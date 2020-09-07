<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Ueb;
use App\User;

class Provincia extends Model
{
     protected $fillable = [
        'name', 'activa', 'observaciones',
    ];//
     
     public function uebs() {
        return $this->hasMany('App\Ueb');
    }
}
