<?php

namespace App\Http\Controllers\Servicios;

use App\Instalacion;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class InstalacionController extends Controller {

    public function JSON() {
        Try {
            $instalacions = \App\Instalacion::all();
            return \Response::json($instalacions->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['instalacions' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $instalacions = \App\Instalacion::all(); //->sortByDesc('id') ;
        return view('instalacions.index', compact('instalacions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $instalacions = \App\Instalacion::all();
        return view('instalacions.create', compact('instalacions'));
    }

    public function store(Request $request) {
        // dd($request);
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:instalacions'],
            'activa' => ['boolean'],
            'boolaloj' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Instalacion($attributes))->save();
        if ($retorno) {
            return back()->with('status', '-' . __('Instalacion  insertada'));
            //  return redirect()->to(url('/instalacions'))->with('status', '-' . __('Instalacion insertada'));
        } else {
            return redirect()->to(url('/instalacions'))->with('status', '-' . __('Instalacion no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Instalacion $instalacion) {
        //$instalacion = Instalacion::find($id);
        //dd($instalacion);
        return view('instalacions.show', compact($instalacion, 'instalacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Instalacion $instalacion) {
        return view('instalacions.edit', compact($instalacion, 'instalacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instalacion $instalacion) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200'],
            'activa' => ['required', 'boolean'],
            'boolaloj' => ['required', 'boolean'],
            'observaciones' => [],
        ]);
        $retorno = \DB::table('instalacions')
                ->where('id', $instalacion->id)
                ->update($attributes);
        if ($retorno) {
            return redirect()->to(url('/instalacions'))->with('status', '-' . __('Instalacion Actualizada'));
        } else {
            return redirect()->to(url('/instalacions'))->with('status', '-' . __('Instalacion no Actualizada'));
        }
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Instalacion $id) {
        \DB::table('instalacions')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/instalacions'))->with('status', '-' . __('Instalacion Inactiva'));
        //return view('instalacions.ban', compact($instalacion, 'instalacion'));//no me preguntes porque funciona
    }

}
