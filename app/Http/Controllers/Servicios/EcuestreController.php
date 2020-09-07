<?php

namespace App\Http\Controllers\Servicios;

use App\Ecuestre;
use App\Gastronomia;
use App\Reserva;
use App\Ueb;
use App\ReservaEcuestre;
use App\Servicio;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class EcuestreController extends Controller
{
     public function JSON() {
        Try {
            $ecuestres = \App\Ecuestre::all();
            return \Response::json($ecuestres->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['ecuestres' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ecuestres = \App\Ecuestre::all(); //->sortByDesc('id') ;  
        $uebs = \App\Ueb::all();
        return view('ecuestres.index', compact('ecuestres','uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ecuestres = \App\Ecuestre::all();
        $instalacions = \App\Instalacion::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('ecuestres.create', compact('ecuestres', 'instalacions','provincias','uebs'));
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
        //dd($request);
        $attributes = $request->validate([
            'name' => ['required'],
            'capacidad' => ['required'],            
            'paxs' => [],            
            'disponibilidad' => [],  
            'ueb_id' => ['required'],
            'activa' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Ecuestre($attributes))->save();
         $updated = \DB::table('ecuestres')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
      
        $fullname = $retorno->name . '-Ecuestre';
        $service = $this->CrearServicio($fullname, 'App\Ecuestre', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Ecuestre  insertado'));
        } else {
            return redirect()->to(url('/ecuestres'))->with('status', '-' . __('Servicio Ecuestre no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ecuestre  $ecuestre
     * @return \Illuminate\Http\Response
     */
    public function show(Ecuestre $ecuestre)
    {
         return view('ecuestres.show', compact($ecuestre, 'ecuestre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ecuestre  $ecuestre
     * @return \Illuminate\Http\Response
     */
    public function edit(Ecuestre $ecuestre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ecuestre  $ecuestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ecuestre $ecuestre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ecuestre  $ecuestre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ecuestre $ecuestre)
    {
        //
    }
}
