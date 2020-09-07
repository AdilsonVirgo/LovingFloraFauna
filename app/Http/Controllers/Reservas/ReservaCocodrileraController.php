<?php

namespace App\Http\Controllers\Reservas;

use App\ReservaCocodrilera;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Reserva;


class ReservaCocodrileraController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rcocodrileras = \App\ReservaCocodrilera::all();
        return view('reservas.rcocodrileras.index', compact('rcocodrileras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $cocodrileras = \App\Cocodrilera::all();
        $mercados = \App\Mercado::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('reservas.rcocodrileras.create', compact('cocodrileras', 'provincias', 'uebs', 'mercados', 'nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->cocodrilera_id;
        $watchtypex = "App\Cocodrilera";
        $reservablex = "App\ReservaCocodrilera";
        $plan = $request->plan;
        $mercado_id = $request->mercado_id;
        $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
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
        $first = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_entrada);
        $second = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_salida);
        
        //$first = new Carbon\Carbon($fecha_entrada, null); //array[5]//       
       // $second = new Carbon($fecha_salida, null); //array[6]
        
        $alojtemp = \App\Cocodrilera::find($request->cocodrilera_id);
        $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
        $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
        if ($cumpletodo) {
            $retorno = ReservaCocodrilera::create([
                        'name' => $name,
                        'cocodrilera_id' => $watchtidx,
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
            $users = \App\User::all();
            /*foreach ($users as $key => $value) {
                $value->notify(new NotificacionReserva($reserva));
            }*/
        } else {
            return back()->withInput()->with('status', '-' . __('Esta Cocodrilera no tiene dispo, por favor cambie los datos'));
        }
        if ($retorno) {
            return back()->with('status', '-' . __('Reserva  insertada'));
        } else {
            return redirect()->to(url('/rcocodrileras'))->with('status', '-' . __('Reserva  no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaCocodrilera  $reservaCocodrilera
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaCocodrilera $reservaCocodrilera) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaCocodrilera  $reservaCocodrilera
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaCocodrilera $reservaCocodrilera) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaCocodrilera  $reservaCocodrilera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaCocodrilera $reservaCocodrilera) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaCocodrilera  $reservaCocodrilera
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaCocodrilera $reservaCocodrilera) {
        //
    }

}
