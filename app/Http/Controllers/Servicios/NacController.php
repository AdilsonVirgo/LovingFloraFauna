<?php

namespace App\Http\Controllers\Servicios;

use App\Nac;


use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class NacController extends Controller
{
     public function JSON() {
        Try {
            $nacs = \App\Nac::all();
            $logmessage = 'Good';
            
            return \Response::json($nacs->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['nacs' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $nacs = \App\Nac::all(); 
        return view('nacs.index', compact('nacs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $nacs = \App\Nac::all();
        return view('nacs.create', compact('nacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:nacs'],
            'activa' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Nac($attributes))->save();
        if ($retorno) {
            return back()->with('status', '-' . __('Nacionalidad insertada'));
        } else {
            return redirect()->to(url('/nacs'))->with('status', '-' . __('Nacionalidad no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nac  $nac
     * @return \Illuminate\Http\Response
     */
    public function show(Nac $nac)
    {
         return view('nacs.show', compact($nac, 'nac'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nac  $nac
     * @return \Illuminate\Http\Response
     */
    public function edit(Nac $nac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nac  $nac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nac $nac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nac  $nac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nac $nac)
    {
        //
    }
}
