<?php

namespace App\Http\Controllers\Servicios;

use App\Alojamiento;
use App\Ueb;
use App\Servicio;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Support\Facades\Validator;
use \App\Http\Controllers\Controller;

class AlojamientoController extends Controller {

    public function JSON() {
        Try {
            $alojamientos = \App\Alojamiento::all();
            return \Response::json($alojamientos->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['alojamientos' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $alojamientos = \App\Alojamiento::all(); //->sortByDesc('id') ;
        /* $post = Alojamiento::find(1);
          foreach ($alojamientos as $k=> $value) {
          dd($value->reservaalojamiento->reserva->reservable);
          }
          $comment = \App\Reserva::find(1);
          $commentable = $comment->reservable;
          dd($commentable); */
        return view('alojamientos.index', compact('alojamientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $alojamientos = \App\Alojamiento::all();
        $uebs = \App\Ueb::all();
        return view('alojamientos.create', compact('alojamientos', 'uebs'));
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

    public function store(Request $request) {
        $total_pax = $request->sencilla + ($request->doble * 2) + ($request->triple * 3) +
                ($request->cuadruple * 3) + ($request->albergue * 8);
        $attributes = $request->validate([
            'name' => ['required'],
            'ueb_id' => ['required'],
            'capacidad' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value < (request()->sencilla + (request()->doble * 2) + (request()->triple * 3) +
                            (request()->cuadruple * 3) + (request()->albergue * 8))) {
                        $fail($attribute . ' debe ser mayor que ' . (request()->sencilla + (request()->doble * 2) + (request()->triple * 3) +
                                (request()->cuadruple * 3) + (request()->albergue * 8)));
                    }
                },
            ],
            'paxs' => [],
            'disponibilidad' => [],
            'sencilla' => [],
            'doble' => [],
            'triple' => [],
            'cuadruple' => [],
            'albergue' => [],
            'observaciones' => [],
        ]);
        $retorno = tap(new Alojamiento($attributes))->save();
        $updated = \DB::table('alojamientos')->where('id', $retorno->id)->update(['disponibilidad' => $retorno->capacidad]);
        $fullname = $retorno->name . '-Alojamiento';
        $service = $this->CrearServicio($fullname, 'App\Alojamiento', $retorno->id, $request->capacidad, true, $request->observaciones);

        if ($retorno) {
            return back()->with('status', '-' . __('Servicio Alojamiento  insertado'));
        } else {
            return redirect()->to(url('/alojamientos'))->with('status', '-' . __('Servicio Alojamiento no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alojamiento  $alojamiento
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Alojamiento $alojamiento) {
        //$alojamiento = Alojamiento::find($id);
        //dd($alojamiento);
        return view('alojamientos.show', compact($alojamiento, 'alojamiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alojamiento  $alojamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Alojamiento $alojamiento) {
        return view('alojamientos.edit', compact($alojamiento, 'alojamiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alojamiento  $alojamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alojamiento $alojamiento) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200'],
            'activa' => ['required', 'boolean'],
            'boolaloj' => ['required', 'boolean'],
            'observaciones' => [],
        ]);
        $retorno = \DB::table('alojamientos')
                ->where('id', $alojamiento->id)
                ->update($attributes);
        if ($retorno) {
            return redirect()->to(url('/alojamientos'))->with('status', '-' . __('Alojamiento Actualizada'));
        } else {
            return redirect()->to(url('/alojamientos'))->with('status', '-' . __('Alojamiento no Actualizada'));
        }
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Alojamiento $id) {
        \DB::table('alojamientos')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/alojamientos'))->with('status', '-' . __('Alojamiento Inactiva'));
        //return view('alojamientos.ban', compact($alojamiento, 'alojamiento'));//no me preguntes porque funciona
    }

}
