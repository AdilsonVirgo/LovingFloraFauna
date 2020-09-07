<?php

namespace App\Http\Controllers\Servicios;

use App\Obs;
use App\ReservaObs;
use App\Reserva;
use App\Servicio;
use App\User;
use App\Ueb;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class ObsController extends Controller {

    public function JSON() {
        Try {
            $obs = \App\Obs::all();
            return \Response::json($obs->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['obs' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $obs = \App\Obs::all();
        $uebs = \App\Ueb::all();
        return view('obs.index', compact('obs', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $obs = \App\Obs::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('obs.create', compact('obs', 'provincias', 'uebs'));
    }

    public function CrearServicio($name, $class, $id, $capacidad, $activa, $observaciones) {
        $attributes = ['name' => $name, 'watchable_type' => $class, 'watchable_id' => $id, 'capacidad' => $capacidad, 'activa' => $activa, 'observaciones' => $observaciones,];
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
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'ueb_id' => ['required'],
            'activa' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Obs($attributes))->save();
        $updated = \DB::table('obs')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Obs';
        $service = $this->CrearServicio($fullname, 'App\Obs', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Obs  insertado'));
        } else {
            return redirect()->to(url('/obs'))->with('status', '-' . __('Servicio Obs no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Obs  $obs
     * @return \Illuminate\Http\Response
     */
    public function show(Obs $obs) {
         return view('obs.show', compact($obs, 'obs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Obs  $obs
     * @return \Illuminate\Http\Response
     */
    public function edit(Obs $obs) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Obs  $obs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obs $obs) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Obs  $obs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obs $obs) {
        //
    }

}
