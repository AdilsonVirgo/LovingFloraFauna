<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaFluvial;
use App\Reserva;
use App\Fluvial;
use App\Servicio;
use App\Mercado;
use App\Provincia;
use App\Ueb;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaFluvialController extends Controller {

    public function JSON() {
        Try {
            $fluvials = \App\ReservaFluvial::all();
            //$provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json($fluvials->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['fluvials' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rfluvials = \App\ReservaFluvial::all(); //->sortByDesc('id') ;
        return view('rfluvials.index', compact('rfluvials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $fluvials = \App\Fluvial::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('rfluvials.create', compact('fluvials', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->fluvial_id;
        $watchtypex = "App\Fluvial";
        $reservablex = "App\ReservaFluvial";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Fluvial::find($watchtidx)->ueb_id;
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
                    $alojtemp = \App\Fluvial::find($request->fluvial_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaFluvial::create(['name' => $name, 'fluvial_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);

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
            return back()->with('status', '-' . __('Reserva Fluvial insertada'));
        } else {
            return redirect()->to(url('/rfluvials'))->with('status', '-' . __('Reserva Fluvial no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaFluvial  $reservaFluvial
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaFluvial $reservaFluvial) {
         return view('$rfluvials.show', compact($reservaFluvial, 'reservaFluvial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaFluvial  $reservaFluvial
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaFluvial $reservaFluvial) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaFluvial  $reservaFluvial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaFluvial $reservaFluvial) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaFluvial  $reservaFluvial
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaFluvial $reservaFluvial) {
        //
    }

}
