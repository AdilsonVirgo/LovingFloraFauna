<?php

namespace App\Http\Controllers\Servicios;

use App\Valla;
use App\User;
use App\Ueb;
use App\Reserva;
use App\ReservaValla;
use App\Servicio;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class VallaController extends Controller {

    public function JSON() {
        Try {
            $vallas = \App\Valla::all();
            return \Response::json($vallas->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['vallas' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $vallas = \App\Valla::all(); //->sortByDesc('id') ;
        $uebs = \App\Ueb::all();
        /* $post = Alojamiento::find(1);
          foreach ($vallas as $k=> $value) {
          dd($value->reservaeventos->reserva->reservable);
          }
          $comment = \App\Reserva::find(1);
          $commentable = $comment->reservable;
          dd($commentable); */
        return view('vallas.index', compact('vallas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $vallas = \App\Valla::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        return view('vallas.create', compact('vallas', 'provincias', 'uebs'));
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
        $retorno = tap(new Valla($attributes))->save();
        $updated = \DB::table('vallas')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->name . '-Valla';
        $service = $this->CrearServicio($fullname, 'App\Valla', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Valla  insertado'));
        } else {
            return redirect()->to(url('/vallas'))->with('status', '-' . __('Servicio Valla no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Valla  $valla
     * @return \Illuminate\Http\Response
     */
    public function show(Valla $valla) {
        return view('vallas.show', compact($valla, 'valla'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valla  $valla
     * @return \Illuminate\Http\Response
     */
    public function edit(Valla $valla) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valla  $valla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valla $valla) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Valla  $valla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valla $valla) {
        //
    }

}
