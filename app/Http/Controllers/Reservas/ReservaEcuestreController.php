<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaEcuestre;
use App\Reserva;
use App\Ecuestre;
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

class ReservaEcuestreController extends Controller {

    public function JSON() {
        Try {
            $recuestres = \App\ReservaEcuestre::all();
            return \Response::json($recuestres->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['recuestres' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $recuestres = \App\ReservaEcuestre::all(); //->sortByDesc('id') ;
        //  dd($recuestres->first()->ecuestre->instalacion->name);
        return view('recuestres.index', compact('recuestres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $recuestres = \App\ReservaEcuestre::all();
        $ecuestres = \App\Ecuestre::all();
        $instalacions = \App\Instalacion::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('recuestres.create', compact('recuestres', 'ecuestres', 'instalacions', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->ecuestre_id;
        $watchtypex = "App\Ecuestre";
        $reservablex = "App\ReservaEcuestre";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Ecuestre::find($watchtidx)->ueb_id;
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
                    $alojtemp = \App\Ecuestre::find($request->ecuestre_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaEcuestre::create([
                    'name' => $name,
                    'ecuestre_id' => $watchtidx,
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
        }	}else {
                        return back()->withInput()->with('status', '-' . __('No tiene dispo, por favor cambie los datos'));
                    }


        if ($retorno) {
            return back()->with('status', '-' . __('Reserva  insertada'));
        } else {
            return redirect()->to(url('/recuestres'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaEcuestre  $reservaEcuestre
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaEcuestre $reservaEcuestre) {
         return view('recuestres.show', compact($reservaEcuestre, 'reservaEcuestre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaEcuestre  $reservaEcuestre
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaEcuestre $reservaEcuestre) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaEcuestre  $reservaEcuestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaEcuestre $reservaEcuestre) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaEcuestre  $reservaEcuestre
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaEcuestre $reservaEcuestre) {
        //
    }

}
