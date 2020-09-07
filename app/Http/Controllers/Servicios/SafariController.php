<?php

namespace App\Http\Controllers\Servicios;

use App\Safari;
use App\ReservaSafari;
use App\Servicio;
use App\Reserva;
use App\User;
use App\Provincia;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class SafariController extends Controller {

    public function JSON() {
        Try {
            $safaris = \App\Safari::all();
            return \Response::json($safaris->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['safaris' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $safaris = \App\Safari::all();
        return view('safaris.index', compact('safaris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $safaris = \App\Safari::all();
        $provincias = \App\Provincia::all();
        $mercados = \App\Mercado::all();
        $uebs = \App\Ueb::all();
        return view('safaris.create', compact('safaris', 'provincias', 'mercados', 'uebs'));
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
        $retorno = tap(new Safari($attributes))->save();
        $updated = \DB::table('safaris')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Safari';
        $service = $this->CrearServicio($fullname, 'App\Safari', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Safari  insertado'));
        } else {
            return redirect()->to(url('/safaris'))->with('status', '-' . __('Servicio Safari no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Safari  $safari
     * @return \Illuminate\Http\Response
     */
    public function show(Safari $safari) {
         return view('safaris.show', compact($safari, 'safari'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Safari  $safari
     * @return \Illuminate\Http\Response
     */
    public function edit(Safari $safari) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Safari  $safari
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Safari $safari) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Safari  $safari
     * @return \Illuminate\Http\Response
     */
    public function destroy(Safari $safari) {
        //
    }

}
