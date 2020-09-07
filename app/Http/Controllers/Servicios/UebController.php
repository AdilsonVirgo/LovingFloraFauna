<?php

namespace App\Http\Controllers\Servicios;

use App\Ueb;
use App\Provincia;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class UebController extends Controller {

    public function JSON() {
        Try {
            $uebs = \App\Ueb::all();
            return \Response::json($uebs->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['uebs' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $uebs = \App\Ueb::all(); //->sortByDesc('id') ;
        $provincias = Provincia::all(); //->sortByDesc('id') ;
        return view('uebs.index', compact('uebs','provincias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $uebs = \App\Ueb::all();
        $provincias = Provincia::all();
        return view('uebs.create', compact('uebs','provincias'));
    }

    public function store(Request $request) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:uebs'],
            'activa' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Ueb($attributes))->save();
        if ($retorno) {
            return redirect()->to(url('/uebs'))->with('status', '-' . __('Ueb insertada'));
        } else {
            return redirect()->to(url('/uebs'))->with('status', '-' . __('Ueb no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ueb  $ueb
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Ueb $ueb) {
        //$ueb = Ueb::find($id);
        //dd($ueb);
        return view('uebs.show', compact($ueb, 'ueb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ueb  $ueb
     * @return \Illuminate\Http\Response
     */
    public function edit(Ueb $ueb) {
        return view('uebs.edit', compact($ueb, 'ueb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ueb  $ueb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ueb $ueb) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200'],
            'activa' => ['required', 'boolean'],
            'observaciones' => [],
        ]);
        $retorno = \DB::table('uebs')
                ->where('id', $ueb->id)
                ->update($attributes);
        if ($retorno) {
            return redirect()->to(url('/uebs'))->with('status', '-' . __('Ueb Actualizada'));
        } else {
            return redirect()->to(url('/uebs'))->with('status', '-' . __('Ueb no Actualizada'));
        }
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Ueb $id) {
        \DB::table('uebs')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/uebs'))->with('status', '-' . __('Ueb Inactiva'));
        //return view('uebs.ban', compact($ueb, 'ueb'));//no me preguntes porque funciona
    }

}
