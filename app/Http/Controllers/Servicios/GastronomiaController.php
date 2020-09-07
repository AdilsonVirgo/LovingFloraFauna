<?php

namespace App\Http\Controllers\Servicios;

use App\Gastronomia;
use App\Alojamiento;
use App\Servicio;
use Illuminate\Http\Request;
use App\User;
use App\Ueb;
use App\Notifications\NotificacionReserva;
use \App\Http\Controllers\Controller;

class GastronomiaController extends Controller {

    public function JSON() {
        Try {
            $gastronomias = \App\Gastronomia::all();
            return \Response::json($gastronomias->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['gastronomias' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $gastronomias = \App\Gastronomia::all(); //->sortByDesc('id') ;
        $uebs = \App\Ueb::all();
        /* $post = Alojamiento::find(1);
          foreach ($gastronomias as $k=> $value) {
          dd($value->reservagastronomia->reserva->reservable);
          }
          $comment = \App\Reserva::find(1);
          $commentable = $comment->reservable;
          dd($commentable); */
        return view('gastronomias.index', compact('gastronomias', 'uebs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $gastronomias = \App\Gastronomia::all();
        $uebs = \App\Ueb::all();
        return view('gastronomias.create', compact('gastronomias', 'uebs'));
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
            'ueb_id' => ['required'],
            'capacidad' => ['required'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Gastronomia($attributes))->save();
        $updated = \DB::table('gastronomias')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        
        $fullname = $retorno->ueb->name . '-Gastronomia';
        $service = $this->CrearServicio($fullname, 'App\Gastronomia', $retorno->id, $request->capacidad, true, $request->observaciones);
        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Gastronomia  insertado'));
        } else {
            return redirect()->to(url('/gastronomias'))->with('status', '-' . __('Servicio Gastronomia no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gastronomia  $gastronomia
     * @return \Illuminate\Http\Response
     */
    public function show(Gastronomia $gastronomia) {
         return view('gastronomias.show', compact($gastronomia, 'gastronomia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gastronomia  $gastronomia
     * @return \Illuminate\Http\Response
     */
    public function edit(Gastronomia $gastronomia) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gastronomia  $gastronomia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gastronomia $gastronomia) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gastronomia  $gastronomia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gastronomia $gastronomia) {
        //
    }

}
