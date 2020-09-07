<?php

namespace App\Http\Controllers\Servicios;

use App\dispolist;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class DispolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $dispos = \App\dispolist::all(); 
        return view('dispos.index', compact('dispos'));
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
     * @param  \App\dispolist  $dispolist
     * @return \Illuminate\Http\Response
     */
    public function show(dispolist $dispolist)
    {
         return view('dispolists.show', compact($dispolist, 'dispolist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dispolist  $dispolist
     * @return \Illuminate\Http\Response
     */
    public function edit(dispolist $dispolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dispolist  $dispolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dispolist $dispolist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\dispolist  $dispolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(dispolist $dispolist)
    {
        //
    }
}
