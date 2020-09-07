<?php

namespace App\Http\Controllers\Servicios;;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class InformeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $alojamientos = \App\Alojamiento::all();
        $cocodrileras = \App\Cocodrilera::all();
        $ecuestres = \App\Ecuestre::all();
        $eventos = \App\Evento::all();
        $excursions = \App\Excursion::all();
        $gastronomias = \App\Gastronomia::all();
        $nauticas = \App\Nautica::all();
        $safaris = \App\Safari::all();
        $senderos = \App\Sendero::all();
        $ofertas = \App\Oferta::all();
        $obs = \App\Obs::all();
        $fluvials = \App\Fluvial::all();
        $vallas = \App\Valla::all();
        $pescas = \App\Pesca::all();
        return view('informes.index', compact('alojamientos', 'cocodrileras', 'ecuestres', 'eventos', 'excursions', 'gastronomias', 'nauticas', 'safaris', 'senderos', 'ofertas', 'obs', 'fluvials', 'vallas', 'pescas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
