<?php

namespace App\Http\Controllers\Servicios;

use App\Excursion;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class ExcursionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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
     * @param  \App\Excursion  $excursion
     * @return \Illuminate\Http\Response
     */
    public function show(Excursion $excursion) {
         return view('excursions.show', compact($excursion, 'excursion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Excursion  $excursion
     * @return \Illuminate\Http\Response
     */
    public function edit(Excursion $excursion) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Excursion  $excursion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Excursion $excursion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Excursion  $excursion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Excursion $excursion) {
        //
    }

}
