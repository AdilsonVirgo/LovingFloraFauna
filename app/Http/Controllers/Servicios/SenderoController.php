<?php

namespace App\Http\Controllers\Servicios;

use App\Sendero;
use App\Servicio;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class SenderoController extends Controller {

    public function JSON() {
        Try {
            $mercados = \App\Sendero::all();
            //$provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json($mercados->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['mercados' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $senderos = \App\Sendero::all(); //->sortByDesc('id') ;
        return view('senderos.index', compact('senderos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $senderos = \App\Sendero::all();
        $uebs = \App\Ueb::all();
        return view('senderos.create', compact('senderos', 'uebs'));
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
            'capacidad' => ['required'],
            'paxs' => [],
            'disponibilidad' => [],
            'ueb_id' => [],
            'albergue' => [],
            'observaciones' => [],
        ]);
        $retorno = tap(new Sendero($attributes))->save();
        $updated = \DB::table('senderos')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Sendero';
        $service = $this->CrearServicio($fullname, 'App\Sendero', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Sendero insertado'));
            // return redirect()->to(url('/senderos'))->with('status', '-' . __('Servicio Sendero insertado'));
        } else {
            return redirect()->to(url('/senderos'))->with('status', '-' . __('Servicio Sendero no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sendero  $sendero
     * @return \Illuminate\Http\Response
     */
    public function show(Sendero $sendero) {
        return view('senderos.show', compact($sendero, 'sendero'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sendero  $sendero
     * @return \Illuminate\Http\Response
     */
    public function edit(Sendero $sendero) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sendero  $sendero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sendero $sendero) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sendero  $sendero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sendero $sendero) {
        //
    }

}
