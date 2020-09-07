<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaNautica;
use App\ReservaEcuestre;
use App\Reserva;
use App\Nautica;
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

class ReservaNauticaController extends Controller {

    public function JSON() {
        Try {
            $rnauticas = \App\ReservaNautica::all();
            return \Response::json($rnauticas->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['rnauticas' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rnauticas = \App\ReservaNautica::all(); //->sortByDesc('id') ;
        //  dd($rnauticas->first()->nautica->instalacion->name);
        return view('rnauticas.index', compact('rnauticas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $rnauticas = \App\ReservaNautica::all();
        $nauticas = \App\Nautica::all();
        $instalacions = \App\Instalacion::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('rnauticas.create', compact('rnauticas', 'nauticas', 'instalacions', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->nautica_id;
        $watchtypex = "App\Nautica";
        $reservablex = "App\ReservaNautica";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Nautica::find($watchtidx)->ueb_id;
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
                    $alojtemp = \App\Nautica::find($request->nautica_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaNautica::create([
                    'name' => $name,
                    'nautica_id' => $watchtidx,
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
        // dd($serx);
        $servicio_id = $serx->id;
        $reserva->servicios()->attach($servicio_id);
        // dd($reserva->servicios());
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
            return redirect()->to(url('/rnauticas'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaNautica  $reservaNautica
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaNautica $reservaNautica) {
        return view('rnauticas.show', compact($reservaNautica, 'reservaNautica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaNautica  $reservaNautica
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaNautica $reservaNautica) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaNautica  $reservaNautica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaNautica $reservaNautica) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaNautica  $reservaNautica
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaNautica $reservaNautica) {
        //
    }

}
