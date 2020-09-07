<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaSendero;
use App\Reserva;
use App\Sendero;
use App\User;
use App\Servicio;
use App\Notifications\NotificacionReserva;
use App\Provincia;
use App\Ueb;
use App\Agencia;
use App\Mercado;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaSenderoController extends Controller {

    public function JSON() {
        Try {
            $mercados = \App\ReservaSendero::all();
            //$provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json($mercados->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['mercados' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rsenderos = \App\ReservaSendero::all(); //->sortByDesc('id') ;
        return view('rsenderos.index', compact('rsenderos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $senderos = \App\Sendero::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('rsenderos.create', compact('senderos', 'mercados', 'uebs', 'nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        /* $attributes = $request->validate([
          'name' => ['required'],
          'sendero_id' => ['required'],
          'mercado_id' => ['required'],
          'total_pax' => ['required'],
          'plan' => ['required'],
          'name_client' => ['required'],
          'fecha_entrada' => ['required'],
          'fecha_salida' => ['required'],
          'activa' => [],
          'observaciones' => [],
          ]);
          $reserva = Reserva::create([
          'name' => $name,
          'total_pax' => $total_pax,
          'fecha_entrada' => $fecha_entrada,
          'fecha_salida' => $fecha_salida,
          'activa' => true,
          'observaciones' => $observaciones,
          ]);
          $watchtidx = $request->sendero_id;
          $watchtypex = "App\Sendero";
          $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
          $servicio_id = $serx->id;
          $name = $request->name;
          $total_pax = $request->total_pax;
          $fecha_entrada = $request->fecha_entrada;
          $fecha_salida = $request->fecha_salida;
          $activa = true;
          $observaciones = $request->observaciones;
          $retorno = tap(new ReservaSendero($attributes))->save();
          $reserva->servicios()->attach($servicio_id); */
        $watchtidx = $request->sendero_id;
        $watchtypex = "App\Sendero";
        $reservablex = "App\ReservaSendero";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Sendero::find($watchtidx)->ueb_id;
        $name = $request->name;
        $total_pax = $request->total_pax;
        $fecha_entrada = $request->fecha_entrada;
        $fecha_salida = $request->fecha_salida;
        $nac_id = $request->nac_id;
        $activa = true;
        $observaciones = $request->observaciones;
        $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Sendero::find($request->sendero_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaSendero::create(['name' => $name, 'sendero_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, $nac_id => 'nac_id', 'activa' => true, 'observaciones' => $observaciones,]);

        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
        $servicio_id = $serx->id;
        $reserva->servicios()->attach($servicio_id);
        $users = \App\User::all();
        foreach ($users as $key => $value) {
            $value->notify(new NotificacionReserva($reserva));
        }
}else {
                        return back()->withInput()->with('status', '-' . __('No tiene dispo, por favor cambie los datos'));
                    }

        if ($retorno) {
            return back()->with('status', '-' . __('Reserva Sendero insertada'));
        } else {
            return redirect()->to(url('/rsenderos'))->with('status', '-' . __('Reserva Sendero no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaSendero  $reservaSendero
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaSendero $reservaSendero) {
        return view('rsenderos.show', compact($reservaSendero, 'reservaSendero'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaSendero  $reservaSendero
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaSendero $reservaSendero) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaSendero  $reservaSendero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaSendero $reservaSendero) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaSendero  $reservaSendero
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaSendero $reservaSendero) {
        //
    }

}
