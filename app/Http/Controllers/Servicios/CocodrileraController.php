<?php

namespace App\Http\Controllers\Servicios;

use App\Cocodrilera;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Sendero;
use App\Servicio;
use App\User;
use App\Ueb;
use App\Instalacion;
use App\Reserva;
use App\ReservaAlojamiento;
use App\ReservaCocodrilera;
use App\Provincia;
use App\ReservaGastronomia;
use App\Notifications\NotificacionReserva;

class CocodrileraController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cocodrileras = Cocodrilera::all();
        return view('servicios.cocodrileras.index', compact('cocodrileras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $cocodrileras = \App\Cocodrilera::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('servicios.cocodrileras.create', compact('cocodrileras', 'provincias', 'uebs'));
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
            'name' => ['required'],
            'ueb_id' => [],
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'albergue' => [],
            'observaciones' => [],
        ]);
        $retorno = tap(new Cocodrilera($attributes))->save();
        /*Actualizar Disponibilidad*/
        \DB::table('cocodrileras')->where('id', $retorno->id)->update(['disponibilidad' => $request->capacidad]);
        
        $fullname = $retorno->name . '-Cocodrilera';
        $service = $this->CrearServicio($fullname, 'App\Cocodrilera', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Cocodrilera insertado'));
            // return redirect()->to(url('/cocodrileras'))->with('status', '-' . __('Servicio Cocodrilera insertado'));
        } else {
            return redirect()->to(url('/cocodrileras'))->with('status', '-' . __('Servicio Cocodrilera no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cocodrilera  $cocodrilera
     * @return \Illuminate\Http\Response
     */
    public function show(Cocodrilera $cocodrilera) {
        return view('cocodrileras.show', compact($cocodrilera, 'cocodrilera'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cocodrilera  $cocodrilera
     * @return \Illuminate\Http\Response
     */
    public function edit(Cocodrilera $cocodrilera) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cocodrilera  $cocodrilera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cocodrilera $cocodrilera) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cocodrilera  $cocodrilera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cocodrilera $cocodrilera) {
        //
    }

    public function JSON() {
        Try {
            $cocos = \App\Cocodrilera::all();
            return \Response::json($cocos->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['cocodrileras' => null, 'error' => $e->getMessage()]);
        }
    }

}
