<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Agencia extends Model
{
    protected $fillable = [
        'name', 'activa', 'observaciones',
    ];
}
