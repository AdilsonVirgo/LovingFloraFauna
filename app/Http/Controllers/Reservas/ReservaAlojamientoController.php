<?php

namespace App\Http\Controllers\Reservas;

use \App\Http\Controllers\Controller;
use App\ReservaAlojamiento;
use App\ReservaEcuestre;
use App\ReservaEvento;
use App\ReservaExcursion;
use App\ReservaCocodrilera;
use App\ReservaFluvial;
use App\ReservaGastronomia;
use App\ReservaNautica;
use App\ReservaObs;
use App\ReservaOferta;
use App\ReservaPesca;
use App\ReservaSendero;
use App\ReservaValla;
use App\Reserva;
use App\Mercado;
use App\Instalacion;
use App\User;
use App\Alojamiento;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \Illuminate\Support\Arr;
use Carbon\Carbon;
use App\dispolist;

class ReservaAlojamientoController extends Controller {

    public function JSON() {
        Try {
            $ralojamientos = \App\ReservaAlojamiento::all();
            return \Response::json($ralojamientos->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['ralojamientos' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ralojamientos = \App\ReservaAlojamiento::all(); //->sortByDesc('id') ;
        //   dd($ralojamientos->first()->name);
        //   dd($ralojamientos->first()->alojamiento->name);
        //   dd($ralojamientos->first()->alojamiento->ueb->name);
        //dd($ralojamientos->first()->alojamiento->ueb->provincia->name);
        return view('ralojamientos.index', compact('ralojamientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ralojamientos = \App\ReservaAlojamiento::all();
        $alojamientos = \App\Alojamiento::all();
        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        $mercados = \App\Mercado::all();
        $nacs = \App\Nac::all();
        return view('ralojamientos.create', compact('ralojamientos', 'alojamientos', 'instalacions', 'mercados', 'uebs', 'nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $watchtidx = $request->alojamiento_id; //alojamientoID 4 'La Casona'       
        $watchtypex = "App\Alojamiento";
        $reservablex = "App\ReservaAlojamiento";
        $sencilla = $request->sencilla;
        $doble = $request->doble;
        $triple = $request->triple;
        $cuadruple = $request->cuadruple;
        $albergue = $request->albergue;
        $plan = $request->plan;
        $mercado_id = $request->mercado_id;

        $name = $request->name;
        $ueb_id = \App\Alojamiento::find($watchtidx)->ueb_id;
        $total_pax = $request->total_pax;
        $fecha_entrada = $request->fecha_entrada;
        $fecha_salida = $request->fecha_salida;
        $nac_id = $request->nac_id;
        $activa = true;
        $observaciones = $request->observaciones;

        $nameReserva = $request->get('name'); //array[0]
        $clienteReserva = "CLIENTE"; //array[1]
        $pilagente_idReserva = $request->get('total_pax'); //array[2]
        $fecha_entrada = $request->get('fecha_entrada'); //array[3]
        $fecha_salida = $request->get('fecha_salida'); //array[4]
        $first = new Carbon($fecha_entrada, null); //array[5]//
        $second = new Carbon($fecha_salida, null); //array[6]
        $alojtemp = Alojamiento::find($request->alojamiento_id);
        $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
        $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
        //dd($cumpletodo);
        if ($cumpletodo) {
            $retorno = ReservaAlojamiento::create([
                        'name' => $name,
                        'alojamiento_id' => $watchtidx,
                        'mercado_id' => $mercado_id,
                        'total_pax' => $total_pax,
                        'sencilla' => $sencilla,
                        'doble' => $doble,
                        'triple' => $triple,
                        'cuadruple' => $cuadruple,
                        'albergue' => $albergue,
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
            //act num reserva
            $var = $reserva->id;
            \DB::table('reservas')->where('id', $var)->update(['numero' => $var]);

            $users = \App\User::all();
            foreach ($users as $key => $value) {
                $value->notify(new NotificacionReserva($reserva));
            }
            //tu numero de reserva es 
            return back()->with('status', 'Tu numero de reserva es: ' . $reserva->id . '  ' . '-' . __('Reserva  insertada'));
        } else {
            return back()->with('status', '-' . __('Reserva NO insertada, falta la capacidad'));
        }
    }

    /* MIXTAS */

    public function mixtas() {
        $ralojamientos = \App\ReservaAlojamiento::all();
        $alojamientos = \App\Alojamiento::all();
        $cocodrileras = \App\Cocodrilera::all();
        $ecuestres = \App\Ecuestre::all();
        $eventos = \App\Evento::all();
        $fluvials = \App\Fluvial::all();
        $gastronomias = \App\Gastronomia::all();
        $nauticas = \App\Nautica::all();
        $obs = \App\Obs::all();
        $pescas = \App\Pesca::all();
        $safaris = \App\Safari::all();
        $senderos = \App\Sendero::all();

        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        $mercados = \App\Mercado::all();
        $nacs = \App\Nac::all();
        return view('mixtas.create', compact('cocodrileras', 'eventos', 'fluvials', 'obs', 'pescas', 'safaris', 'nauticas', 'gastronomias', 'senderos', 'ecuestres', 'ralojamientos', 'alojamientos', 'instalacions', 'mercados', 'uebs', 'nacs'));
    }

    /* MIXTAS POST */

    public function mixtasstore(Request $request) {
        //alojamiento,ecuestre,sendero,gastronomia,nautica,        //dd($request->request);        //echo(count($request->request));
        $counter = 0;        //todos los checks que esten marcados
        foreach ($request->request as $key => $value) {
            if ($value != null) {
                $counter ++;
            }
        }
        if ($counter < 10) {
            return back()->withInput()->with('status', '-' . __('Debe seleccionar al menos 2 servicios y llenar todos los campos'));
        } else {
            // dd($request);
            if (false) {
                return back()->withInput()->with('status', '-' . __('Estos Servicios no tienen dispo, por favor cambie los datos'));
            }//true !hayDispo($request)
            else {
                $var = 0;
                $collect = array();
                if ($request->myCheckAlojamiento == "on") {
                    $watchtidx = $request->alojamiento_id; //alojamientoID 4 'La Casona'       
                    $watchtypex = "App\Alojamiento";
                    $reservablex = "App\ReservaAlojamiento";
                    $sencilla = $request->sencilla;
                    $doble = $request->doble;
                    $triple = $request->triple;
                    $cuadruple = $request->cuadruple;
                    $albergue = $request->albergue;
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $name = $request->loc;
                    $ueb_id = \App\Alojamiento::find($watchtidx)->ueb_id;
                    $total_pax = $request->total_pax;
                    $fecha_entrada = $request->fecha_entrada;
                    $fecha_salida = $request->fecha_salida;
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $request->get('total_pax'); //array[2]
                    // $fecha_entrada = $request->get('fecha_entrada'); //array[3]
                    //$fecha_salida = $request->get('fecha_salida'); //array[4]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = Alojamiento::find($request->alojamiento_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
                        $retorno = ReservaAlojamiento::create(['name' => $name, 'alojamiento_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'sencilla' => $sencilla, 'doble' => $doble, 'triple' => $triple, 'cuadruple' => $cuadruple, 'albergue' => $albergue, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Este Alojamiento no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckCocodrilera == "on") {
                    $watchtidx = $request->cocodrilera_id;
                    $watchtypex = "App\Cocodrilera";
                    $reservablex = "App\ReservaCocodrilera";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxcocodrilera;
                    $fecha_entrada = $request->fecha_entradacocodrilera; //array[3]
                    $fecha_salida = $request->fecha_salidacocodrilera; //array[4]
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Cocodrilera::find($request->cocodrilera_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
                        $retorno = ReservaCocodrilera::create(['name' => $name, 'cocodrilera_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Cocodrilera no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckEcuestre == "on") {
                    $watchtidx = $request->ecuestre_id;
                    $watchtypex = "App\Ecuestre";
                    $reservablex = "App\ReservaEcuestre";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Ecuestre::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxecuestre;
                    $fecha_entrada = $request->fecha_entradaecuestre;
                    $fecha_salida = $request->fecha_salidaecuestre;
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    //$fecha_entrada = $request->get('fecha_entrada'); //array[3]
                    //$fecha_salida = $request->get('fecha_salida'); //array[4]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Ecuestre::find($request->ecuestre_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    // dd($cumpletodo);
                    if ($cumpletodo) {
                        $retorno = ReservaEcuestre::create(['name' => $name, 'ecuestre_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);

                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Este Ecuestre no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckEvento == "on") {
                    $watchtidx = $request->evento_id;
                    $watchtypex = "App\Evento";
                    $reservablex = "App\ReservaEvento";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Evento::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxevento;
                    $fecha_entrada = $request->fecha_entradaevento;
                    $fecha_salida = $request->fecha_salidaevento;
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Evento::find($request->evento_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
                        $retorno = ReservaEvento::create(['name' => $name, 'evento_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Este Evento no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckFluvial == "on") {
                    $watchtidx = $request->fluvial_id;
                    $watchtypex = "App\Fluvial";
                    $reservablex = "App\ReservaFluvial";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Fluvial::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxfluvial;
                    $fecha_entrada = $request->fecha_entradafluvial;
                    $fecha_salida = $request->fecha_salidafluvial;
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
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Este Fluvial no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckGastronomia == "on") {
                    $watchtidx = $request->gastronomia_id;
                    $watchtypex = "App\Gastronomia";
                    $reservablex = "App\ReservaGastronomia";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Gastronomia::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxgastronomia;
                    $fecha_entrada = $request->fecha_entradagastronomia;
                    $fecha_salida = $request->fecha_salidagastronomia;
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
                        $retorno = ReservaGastronomia::create(['name' => $name, 'gastronomia_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Gastronomia no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckNautica == "on") {
                    $watchtidx = $request->nautica_id;
                    $watchtypex = "App\Nautica";
                    $reservablex = "App\ReservaNautica";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Nautica::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxnautica;
                    $fecha_entrada = $request->fecha_entradanautica;
                    $fecha_salida = $request->fecha_salidanautica;
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
                        $retorno = ReservaNautica::create(['name' => $name, 'ecuestre_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Nautica no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckObs == "on") {
                    $watchtidx = $request->obs_id;
                    $watchtypex = "App\Obs";
                    $reservablex = "App\ReservaObs";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Obs::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxobs;
                    $fecha_entrada = $request->fecha_entradaobs;
                    $fecha_salida = $request->fecha_salidaobs;
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Obs::find($request->obs_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
                        $retorno = ReservaObs::create(['name' => $name, 'obs_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Observacion no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckPesca == "on") {
                    $watchtidx = $request->pesca_id;
                    $watchtypex = "App\Pesca";
                    $reservablex = "App\ReservaPesca";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Pesca::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxpesca;
                    $fecha_entrada = $request->fecha_entradapesca;
                    $fecha_salida = $request->fecha_salidapesca;
                    $nac_id = $request->nac_id;
                    $activa = true;
                    $observaciones = $request->observaciones;
                    $nameReserva = $name; //array[0]
                    $clienteReserva = "CLIENTE"; //array[1]
                    $pilagente_idReserva = $total_pax; //array[2]
                    $first = new Carbon($fecha_entrada, null); //array[5]//
                    $second = new Carbon($fecha_salida, null); //array[6]
                    $alojtemp = \App\Pesca::find($request->pesca_id);
                    $servicio_id = $alojtemp->servicio->id; //array[7]//servicio_id
                    $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
                    if ($cumpletodo) {
                        $retorno = ReservaPesca::create(['name' => $name, 'pesca_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Pesca no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckSafari == "on") {
                    $watchtidx = $request->safari_id;
                    $watchtypex = "App\Safari";
                    $reservablex = "App\ReservaSafari";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Safari::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxsafari;
                    $fecha_entrada = $request->fecha_entradasafari;
                    $fecha_salida = $request->fecha_salidasafari;
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
                        $retorno = ReservaSafari::create(['name' => $name, 'safari_id' => $watchtidx, 'mercado_id' => $mercado_id, 'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'activa' => true, 'observaciones' => $observaciones,]);
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Este Safari no tiene dispo, por favor cambie los datos'));
                    }
                }
                if ($request->myCheckSendero == "on") {
                    $watchtidx = $request->sendero_id;
                    $watchtypex = "App\Sendero";
                    $reservablex = "App\ReservaSendero";
                    $plan = $request->plan;
                    $mercado_id = $request->mercado_id;
                    $ueb_id = \App\Sendero::find($watchtidx)->ueb_id;
                    $name = $request->loc;
                    $total_pax = $request->total_paxsendero;
                    $fecha_entrada = $request->fecha_entradasendero;
                    $fecha_salida = $request->fecha_salidasendero;
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
                        $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex, 'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => true, 'observaciones' => $observaciones,]);
                        $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
                        $servicio_id = $serx->id;
                        $reserva->servicios()->attach($servicio_id);
                        $var = $reserva->id;
                        array_push($collect, $var);
                        \DB::table('reservas')->where('id', $var)->update(['numero' => $collect[0]]);
                        $users = \App\User::all();
                        foreach ($users as $key => $value) {
                            $value->notify(new NotificacionReserva($reserva));
                        }
                    } else {
                        return back()->withInput()->with('status', '-' . __('Esta Sendero no tiene dispo, por favor cambie los datos'));
                    }
                }

                //tu numero de reserva es 
                return back()->with('status', 'Tu numero de reserva es: ' . $collect[0] . '  ' . '-' . __('Reservas  insertadas'));
            }            //notificar
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaAlojamiento  $reservaAlojamiento
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaAlojamiento $reservaAlojamiento) {
         return view('ralojamientos.show', compact($reservaAlojamiento, 'reservaAlojamiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaAlojamiento  $reservaAlojamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservaAlojamiento $reservaAlojamiento) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaAlojamiento  $reservaAlojamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaAlojamiento $reservaAlojamiento) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaAlojamiento  $reservaAlojamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaAlojamiento $reservaAlojamiento) {
        //
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(ReservaAlojamiento $id) {
        \DB::table('reserva_alojamientos')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/ralojamientos'))->with('status', '-' . __('Reserva Alojamiento Inactiva'));
    }

}
