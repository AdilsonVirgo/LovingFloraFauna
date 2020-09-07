<?php

namespace App\Http\Controllers\Servicios;

use App\Mercado;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class MercadoController extends Controller {

    public function JSON() {
        Try {
            $mercados = \App\Mercado::all();
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
        $mercados = \App\Mercado::all(); //->sortByDesc('id') ;
        return view('mercados.index', compact('mercados'));
        // return view('provincias.i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $mercados = \App\Mercado::all();
        return view('mercados.create', compact('mercados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:mercados'],
            'activa' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Mercado($attributes))->save();
        if ($retorno) {
            return back()->with('status', '-' . __('Mercado insertado'));
            //return redirect()->to(url('/mercados'))->with('status', '-' . __('Mercado insertada'));
        } else {
            return redirect()->to(url('/mercados'))->with('status', '-' . __('Mercado no insertado'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mercado  $mercado
     * @return \Illuminate\Http\Response
     */
    public function show(Mercado $mercado) {
         return view('mercados.show', compact($mercado, 'mercado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tmercado  $tmercado
     * @return \Illuminate\Http\Response
     */
    public function edit(Tmercado $tmercado) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tmercado  $tmercado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tmercado $tmercado) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tmercado  $tmercado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tmercado $tmercado) {
        //
    }

}
