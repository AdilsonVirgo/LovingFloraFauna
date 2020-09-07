<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nac extends Model
{
    protected $fillable = [
        'name', 'activa', 'observaciones',
    ];
}
