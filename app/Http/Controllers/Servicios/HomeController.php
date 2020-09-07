<?php

namespace App\Http\Controllers\Servicios;

use App\Agencia;
use App\User;
use App\Reserva;
use App\ReservaAlojamiento;
use App\ReservaSendero;
use App\Sendero;
use App\Servicio;
use App\Alojamiento;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $authuser = auth()->user();
        //$level = "TEST";      
        return view('home');
    }

    public function allNotifications() {
        $authuser = auth()->user();
        $all = $authuser->notifications;
        return view('notificationes.index', compact('all')); //aqui cargo las notificaciones
    }

    public function Notis() {
        $authuser = auth()->user();
        return $authuser->unreadNotifications;
    }

    public function CountNotifications() {
        $authuser = auth()->user();
        return count($authuser->unreadNotifications);
    }

    //reservas notificadas
    //entradas
    public function EntryNotifications() {
        $authuser = auth()->user();
        $all = $authuser->notifications;
        $notifications = [];
        foreach ($all as $key => $value) {
            if ($value->data['fe'] === today()->format("Y-m-d")) {
                array_push($notifications, $value);
            }
        }
        return view('notificationes.entry', compact('notifications')); //aqui cargo las notificaciones
    }

    public function CountEntryNotifications() {
        $authuser = auth()->user();
        $all = $authuser->notifications;
        $contador = 0;
        foreach ($all as $key => $value) {
            if ($value->data['fe'] === today()->format("Y-m-d")) {
                $contador++;
            }
        }
        return $contador;
    }

    //salidas
    public function ExitNotifications() {
        $authuser = auth()->user();
        $all = $authuser->notifications;
        $notifications = [];
        foreach ($all as $key => $value) {
            if ($value->data['fs'] === today()->format("Y-m-d")) {
                array_push($notifications, $value);
            }
        }
        return view('notificationes.exit', compact('notifications')); //aqui cargo las notificaciones
    }

    public function CountExitNotifications() {
        $authuser = auth()->user();
        $all = $authuser->notifications;
        $contador = 0;
        foreach ($all as $key => $value) {
            if ($value->data['fs'] === today()->format("Y-m-d")) {
                $contador++;
            }
        }
        return $contador;
    }

    public function CrearCupon() {
        /*     <style>
          body {
          font-family: Arial;
          }

          .coupon {
          border: 5px dotted #bbb;
          width: 80%;
          border-radius: 15px;
          margin: 0 auto;
          max-width: 600px;
          }

          .container {
          padding: 2px 16px;
          background-color: #f1f1f1;
          }

          .promo {
          background: #ccc;
          padding: 3px;
          }

          .expire {
          color: red;
          }
          </style>
          </head>
          <body>

          <div class="coupon">
          <div class="container">
          <h3>Company Logo</h3>
          </div>
          <img src="/w3images/hamburger.jpg" alt="Avatar" style="width:100%;">
          <div class="container" style="background-color:white">
          <h2><b>20% OFF YOUR PURCHASE</b></h2>
          <p>Lorem ipsum dolor sit amet, et nam pertinax gloriatur. Sea te minim soleat senserit, ex quo luptatum tacimates voluptatum, salutandi delicatissimi eam ea. In sed nullam laboramus appellantur, mei ei omnis dolorem mnesarchum.</p>
          </div>
          <div class="container">
          <p>Use Promo Code: <span class="promo">BOH232</span></p>
          <p class="expire">Expires: Jan 03, 2021</p>
          </div>
          </div> */
    }

}
