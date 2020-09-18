<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NomencladoresAPIController extends Controller {

    /**Todos en plural y una especifica en singular*/
    public function mercado($id) {
        return \App\Mercado::find($id);
    }

    public function mercados() {
        return \App\Mercado::all();
    }
    
    public function nacionalidad($id) {
        return \App\Nac::find($id);
    }

    public function nacionalidades() {
        return \App\Nac::all();
    }
    
    public function agencia($id) {
        return \App\Agencia::find($id);
    }

    public function agencias() {
        return \App\Agencia::all();
    }
    
    
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
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
