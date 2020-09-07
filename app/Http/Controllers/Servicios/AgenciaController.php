<?php

namespace App\Http\Controllers\Servicios;

use App\User;
use App\Agencia;
use Illuminate\Http\Request;
use App\Notifications\NotificacionReserva;
use \App\Http\Controllers\Controller;

class AgenciaController extends Controller {

    public function JSON() {
        Try {
            $agencias = \App\Agencia::all();
            return \Response::json($agencias->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['agencias' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $agencias = \App\Agencia::all(); //->sortByDesc('id') ;
        return view('agencias.index', compact('agencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $agencias = \App\Agencia::all();
        return view('agencias.create', compact('agencias'));
    }

    public function store(Request $request) {
        dd($request);
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:agencias'],
            'activa' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Agencia($attributes))->save();
        if ($retorno) {
            return redirect()->to(url('/agencias'))->with('status', '-' . __('Agencia insertada'));
        } else {
            return redirect()->to(url('/agencias'))->with('status', '-' . __('Agencia no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agencia  $agencia
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Agencia $agencia) {
        //$agencia = Agencia::find($id);
        //dd($agencia);
        return view('agencias.show', compact($agencia, 'agencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agencia  $agencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Agencia $agencia) {
        return view('agencias.edit', compact($agencia, 'agencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agencia  $agencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agencia $agencia) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200'],
            'activa' => ['required', 'boolean'],
            'observaciones' => [],
        ]);
        $retorno = \DB::table('agencias')
                ->where('id', $agencia->id)
                ->update($attributes);
        if ($retorno) {
            return redirect()->to(url('/agencias'))->with('status', '-' . __('Agencia Actualizada'));
        } else {
            return redirect()->to(url('/agencias'))->with('status', '-' . __('Agencia no Actualizada'));
        }
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Agencia $id) {
        \DB::table('agencias')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/agencias'))->with('status', '-' . __('Agencia Inactiva'));
        //return view('agencias.ban', compact($agencia, 'agencia'));//no me preguntes porque funciona
    }

}
