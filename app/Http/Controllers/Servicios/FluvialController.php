<?php

namespace App\Http\Controllers\Servicios;

use Illuminate\Http\Request;
use App\Fluvial;
use App\Provincia;
use App\Reserva;
use App\Ueb;
use App\User;
use App\ReservaFluvial;
use App\Servicio;
use \App\Http\Controllers\Controller;

class FluvialController extends Controller {

    public function JSON() {
        Try {
            $fluvials = \App\Fluvial::all();
            return \Response::json($fluvials->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['fluvials' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $fluvials = \App\Fluvial::all();
        $uebs = \App\Ueb::all();
        return view('fluvials.index', compact('fluvials', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $fluvials = \App\Fluvial::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('fluvials.create', compact('fluvials', 'provincias', 'uebs'));
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
        // dd($request);
        $attributes = $request->validate([
            'name' => ['required'],
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'ueb_id' => ['required'],
            'activa' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Fluvial($attributes))->save();
        $updated = \DB::table('fluvials')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Fluvial';
        $service = $this->CrearServicio($fullname, 'App\Fluvial', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Fluvial  insertado'));
        } else {
            return redirect()->to(url('/fluvials'))->with('status', '-' . __('Servicio Fluvial no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fluvial  $fluvial
     * @return \Illuminate\Http\Response
     */
    public function show(Fluvial $fluvial) {
         return view('fluvials.show', compact($fluvial, 'fluvial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fluvial  $fluvial
     * @return \Illuminate\Http\Response
     */
    public function edit(Fluvial $fluvial) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fluvial  $fluvial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fluvial $fluvial) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fluvial  $fluvial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fluvial $fluvial) {
        //
    }

}
