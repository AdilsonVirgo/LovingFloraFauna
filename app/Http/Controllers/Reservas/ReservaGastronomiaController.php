<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaGastronomia;
use App\Reserva;
use App\ReservaSendero;
use App\Servicio;
use App\Gastronomia;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaGastronomiaController extends Controller {

    public function JSON() {
        Try {
            $rgastronomias = \App\ReservaGastronomia::all();
            return \Response::json($rgastronomias->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['rgastronomias' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rgastronomias = \App\ReservaGastronomia::all(); //->sortByDesc('id') ;
        //  dd($rgastronomias->first()->gastronomia->instalacion->name);
        return view('rgastronomias.index', compact('rgastronomias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $rgastronomias = \App\ReservaGastronomia::all();
        $gastronomias = \App\Gastronomia::all();
        $instalacions = \App\Instalacion::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('rgastronomias.create', compact('rgastronomias', 'gastronomias', 'instalacions', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->gastronomia_id;
        $watchtypex = "App\Gastronomia";
        $reservablex = "App\ReservaGastronomia";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Gastronomia::find($watchtidx)->ueb_id;
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
                    $alojtemp = \App\Gastronomia::find($request->gastronomia_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
        $retorno = ReservaGastronomia::create([
                    'name' => $name,
                    'gastronomia_id' => $watchtidx,
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
            return redirect()->to(url('/rgastronomias'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaGastronomia  $reservaGastronomia
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaGastronomia $reservaGastronomia) {
        return view('$rgastronomias.show', compact($reservaGastronomia, 'reservaGastronomia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaGastronomia  $reservaGastronomia
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaGastronomia $reservaGastronomia) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaGastronomia  $reservaGastronomia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaGastronomia $reservaGastronomia) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaGastronomia  $reservaGastronomia
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaGastronomia $reservaGastronomia) {
        //
    }

}
