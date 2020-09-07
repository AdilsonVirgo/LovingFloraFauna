
<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;

use App\ReservaEvento;
use App\Notifications\NotificacionReserva;
use App\Reserva;
use App\Evento;
use App\User;
use App\Ueb;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaEventoController extends Controller {

    public function JSON() {
        Try {
            $reventos = \App\ReservaEvento::all();
            return \Response::json($reventos->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['reventos' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $reventos = \App\ReservaEvento::all(); //->sortByDesc('id') ;
        //  dd($reventos->first()->evento->instalacion->name);
        return view('reventos.index', compact('reventos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $reventos = \App\ReservaEvento::all();
        $eventos = \App\Evento::all();
        $instalacions = \App\Instalacion::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('reventos.create', compact('reventos', 'eventos', 'instalacions', 'mercados', 'uebs','nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->evento_id;
        $watchtypex = "App\Evento";
        $reservablex = "App\ReservaEvento";

        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Evento::find($watchtidx)->ueb_id;
        $name = $request->name;
        $total_pax = $request->total_pax;
        $fecha_entrada = $request->fecha_entrada;
        $fecha_salida = $request->fecha_salida;
        $nac_id = $request->nac_id;
        $activa = true;
        $observaciones = $request->observaciones;
        $retorno = ReservaEvento::create([
                    'name' => $name,
                    'evento_id' => $watchtidx,
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

        if ($retorno) {
            return back()->with('status', '-' . __('Reserva  insertada'));
        } else {
            return redirect()->to(url('/reventos'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaEvento  $reservaEvento
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaEvento $reservaEvento) {
        return view('reventos.show', compact($reservaEvento, 'reservaEvento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaEvento  $reservaEvento
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaEvento $reservaEvento) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaEvento  $reservaEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaEvento $reservaEvento) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaEvento  $reservaEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaEvento $reservaEvento) {
        //
    }

}
