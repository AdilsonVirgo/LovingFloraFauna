<?php

namespace App\Http\Controllers\Servicios;

use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class DashboardController extends Controller {

    public function versionone() {
        return view('dashboard.v1');
    }

    public function versiontwo() {
        return view('dashboard.v2');
    }

    public function versionthree() {
        return view('dashboard.v3');
    }

    public function versionfour() {
        return view('dashboard.v4');
    }

}
