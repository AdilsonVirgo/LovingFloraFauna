<?php

namespace App\Http\Controllers\Servicios;

use App\Nautica;
use App\ReservaNautica;
use App\Reserva;
use App\Servicio;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class NauticaController extends Controller {

    public function JSON() {
        Try {
            $nauticas = \App\Nautica::all();
            return \Response::json($nauticas->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['nauticas' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $nauticas = \App\Nautica::all();
        $uebs = \App\Ueb::all();
        return view('nauticas.index', compact('nauticas', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $nauticas = \App\Nautica::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('nauticas.create', compact('nauticas', 'provincias', 'uebs'));
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
        $retorno = tap(new Nautica($attributes))->save();
        $updated = \DB::table('nauticas')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Nautica';
        $service = $this->CrearServicio($fullname, 'App\Nautica', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Nautica  insertado'));
        } else {
            return redirect()->to(url('/nauticas'))->with('status', '-' . __('Servicio Nautica no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nautica  $nautica
     * @return \Illuminate\Http\Response
     */
    public function show(Nautica $nautica) {
         return view('nauticas.show', compact($nautica, 'nautica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nautica  $nautica
     * @return \Illuminate\Http\Response
     */
    public function edit(Nautica $nautica) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nautica  $nautica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nautica $nautica) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nautica  $nautica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nautica $nautica) {
        //
    }

}
