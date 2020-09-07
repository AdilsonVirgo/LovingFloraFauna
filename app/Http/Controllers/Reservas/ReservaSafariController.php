<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaSafari;
use App\Reserva;
use App\User;
use App\Notifications\NotificacionReserva;
use App\Servicio;
use App\Mercado;
use App\Provincia;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaSafariController extends Controller {

    public function JSON() {
        Try {
            $rsafaris = \App\ReservaSafari::all();
            return \Response::json($rsafaris->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['rsafaris' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rsafaris = \App\ReservaSafari::all(); //->sortByDesc('id') ;
        //  dd($rsafaris->first()->safari->instalacion->name);
        return view('rsafaris.index', compact('rsafaris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $rsafaris = \App\ReservaSafari::all();
        $safaris = \App\Safari::all();
        $provincias = \App\Provincia::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('rsafaris.create', compact('rsafaris', 'safaris', 'provincias', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->safari_id;
        $watchtypex = "App\Safari";
        $reservablex = "App\ReservaSafari";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Safari::find($watchtidx)->ueb_id;
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
                    $alojtemp = \App\Safari::find($request->safari_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaSafari::create([
                    'name' => $name,
                    'safari_id' => $watchtidx,
                    'mercado_id' => $mercado_id,
                    'total_pax' => $total_pax,
                    'plan' => $plan,
                    'fecha_entrada' => $fecha_entrada,
                    'fecha_salida' => $fecha_salida,
                    'activa' => true,
                    'observaciones' => $observaciones,
        ]);

        $reserva = Reserva::create([
                    'name' => $name,
                    'ueb_id' => $ueb_id,
                    'reservable_type' => $reservablex,
                    'reservable_id' => $retorno->id,
                    'total_pax' => $total_pax,
                    'fecha_entrada' => $fecha_entrada,
                    'fecha_salida' => $fecha_salida,
                    'nac_id' => $nac_id,
                    'activa' => true,
                    'observaciones' => $observaciones,
        ]);

        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();

        $servicio_id = $serx->id;
        $reserva->servicios()->attach($servicio_id);

        //notificar
        $users = \App\User::all();
        foreach ($users as $key => $value) {
            $value->notify(new NotificacionReserva($reserva));
        }
}else {
                        return back()->withInput()->with('status', '-' . __('No tiene dispo, por favor cambie los datos'));
                    }

        if ($retorno) {
            return back()->with('status', '-' . __('Reserva  insertada'));
        } else {
            return redirect()->to(url('/rsafaris'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaSafari  $reservaSafari
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaSafari $reservaSafari) {
       return view('rsafaris.show', compact($reservaSafari, 'reservaSafari'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaSafari  $reservaSafari
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaSafari $reservaSafari) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaSafari  $reservaSafari
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaSafari $reservaSafari) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaSafari  $reservaSafari
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaSafari $reservaSafari) {
        //
    }

}
