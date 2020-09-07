<?php

namespace App\Http\Controllers\Servicios;

use App\Pesca;
use App\ReservaPesca;
use App\Reserva;
use App\User;
use App\Ueb;
use App\Gastronomia;
use App\Servicio;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class PescaController extends Controller {

    public function JSON() {
        Try {
            $pescas = \App\Pesca::all();
            return \Response::json($pescas->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['pescas' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pescas = \App\Pesca::all();
        $uebs = \App\Ueb::all();
        return view('pescas.index', compact('pescas', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pescas = \App\Pesca::all();
        $uebs = \App\Ueb::all();
        return view('pescas.create', compact('pescas', 'uebs'));
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
            'ueb_id' => [],
            'lugar' => ['required'],
            'embarcacion' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Pesca($attributes))->save();
        $updated = \DB::table('pescas')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Pesca';
        $service = $this->CrearServicio($fullname, 'App\Pesca', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Pesca  insertado'));
        } else {
            return redirect()->to(url('/pescas'))->with('status', '-' . __('Servicio Pesca no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pesca  $pesca
     * @return \Illuminate\Http\Response
     */
    public function show(Pesca $pesca) {
         return view('pescas.show', compact($pesca, 'pesca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pesca  $pesca
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesca $pesca) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pesca  $pesca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesca $pesca) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pesca  $pesca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesca $pesca) {
        //
    }

}
