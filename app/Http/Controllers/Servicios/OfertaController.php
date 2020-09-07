<?php

namespace App\Http\Controllers\Servicios;

use App\Oferta;
use App\User;
use App\Provincia;
use App\Mercado;
use App\Instalacion;
use App\Ueb;
use App\Servicio;
use App\Reserva;
use App\ReservaOferta;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class OfertaController extends Controller {

    public function JSON() {
        Try {
            $ofertas = \App\Oferta::all();
            return \Response::json($ofertas->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['ofertas' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ofertas = \App\Oferta::all();
        $uebs = \App\Ueb::all();
        return view('ofertas.index', compact('ofertas', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ofertas = \App\Oferta::all();
        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        return view('ofertas.create', compact('ofertas', 'instalacions', 'uebs'));
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
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'ueb_id' => ['required'],
            'activa' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Oferta($attributes))->save();
        $updated = \DB::table('ofertas')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->ueb->name . '-Oferta';
        $service = $this->CrearServicio($fullname, 'App\Oferta', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Oferta  insertado'));
        } else {
            return redirect()->to(url('/ofertas'))->with('status', '-' . __('Servicio Oferta no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function show(Oferta $oferta) {
         return view('ofertas.show', compact($oferta, 'oferta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function edit(Oferta $oferta) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Oferta $oferta) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oferta $oferta) {
        //
    }

}
