<?php

namespace App\Http\Controllers\Servicios;

use App\Evento;
use App\Gastronomia;
use App\Reserva;
use App\Ueb;
use App\ReservaEvento;
use App\Servicio;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class EventoController extends Controller {

    public function JSON() {
        Try {
            $eventos = \App\Evento::all();
            return \Response::json($eventos->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['eventos' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $eventos = \App\Evento::all(); //->sortByDesc('id') ;
        /* $post = Alojamiento::find(1);
          foreach ($eventos as $k=> $value) {
          dd($value->reservaeventos->reserva->reservable);
          }
          $comment = \App\Reserva::find(1);
          $commentable = $comment->reservable;
          dd($commentable); */
        return view('eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $eventos = \App\Evento::all();
        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        return view('eventos.create', compact('eventos', 'instalacions','uebs'));
    }

    public function CrearServicio($name, $class, $id, $capacidad, $activa, $observaciones) {
        $attributes = [
            'name' => $name,
            'watchable_type' => $class,
            'watchable_id' => $id,
            'capacidad' => $capacidad,
            'activa' => $activa,
            'observaciones' => $observaciones,
        ];
        $servicio = tap(new Servicio($attributes))->save();
        return $servicio;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $attributes = $request->validate([
            'name' => [],
            'ueb_id' => ['required'],
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'activa' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Evento($attributes))->save();
        $updated = \DB::table('eventos')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->ueb->name . '-Evento';
        $service = $this->CrearServicio($fullname, 'App\Evento', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Evento  insertado'));
        } else {
            return redirect()->to(url('/eventos'))->with('status', '-' . __('Servicio Evento no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento) {
        return view('eventos.show', compact($evento, 'evento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento) {
        //
    }

}
