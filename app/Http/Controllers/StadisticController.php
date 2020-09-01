<?php

namespace App\Http\Controllers;

use App\Stadistic;
use Illuminate\Http\Request;

class StadisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stadistics.stadistics');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stadistic  $stadistic
     * @return \Illuminate\Http\Response
     */
    public function show(Stadistic $stadistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stadistic  $stadistic
     * @return \Illuminate\Http\Response
     */
    public function edit(Stadistic $stadistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stadistic  $stadistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stadistic $stadistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stadistic  $stadistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stadistic $stadistic)
    {
        //
    }
}
