<?php

namespace App\Http\Controllers\Servicios;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use \App\Http\Controllers\Controller;

class BloqueoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $reservas = \App\Reserva::all();
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
        $uebs = \App\Ueb::all();
        //dd($reservas->first()->reservable_type);
        return view('bloqueos.index', compact('reservas', 'uebs', 'alojamientos', 'cocodrileras', 'ecuestres', 'eventos', 'excursions', 'gastronomias', 'nauticas', 'safaris', 'senderos', 'ofertas', 'obs', 'fluvials', 'vallas', 'pescas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $reservas = \App\Reserva::all();
        $mercados = \App\Mercado::all();
        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        $collection = collect([]);
        return view('bloqueos.search', compact('reservas', 'uebs', 'mercados', 'instalacions', 'collection'));
    }

    public function search(Request $request) {
        $rawfull = "";
        $consulta = "activa = 1 ";
        $rawfull = $rawfull . $consulta;
        $tempname = $request->name;
        $tempueb = $request->ueb_id;
        $tempfecha_entrada = $request->fecha_entrada;
        $tempfecha_salida = $request->fecha_salida;
        $temptotal_pax = $request->total_pax;
        $tempreservable_type = $request->reservable_type;
        $tempplan = $request->plan;
        $tempmercado = $request->mercado;
        $array1 = array();
        if ($request->name) {
            $consulta = " AND name like " . "'%" . $request->name . "%'";
            $rawfull = $rawfull . $consulta;
        }
        if ($request->fecha_entrada) {
            $consulta = " AND fecha_entrada >= " . "'" . $request->fecha_entrada . "'";
            $rawfull = $rawfull . $consulta;
        }
        if ($request->fecha_salida) {
            $consulta = " AND fecha_salida <= " . "'" . $request->fecha_salida . "'";
            $rawfull = $rawfull . $consulta;
        }
        if ($request->total_pax) {
            $consulta = " AND total_pax = " . "'" . $request->total_pax . "'";
            $rawfull = $rawfull . $consulta;
        }
        if ($request->ueb_id) {
            $consulta = " AND ueb_id = " . "'" . $request->ueb_id . "'";
            $rawfull = $rawfull . $consulta;
        }
        
        $reservaFirst1 = \DB::table('reservas')->whereRaw($rawfull)->get(); //caso1
        $reservaFirst = \App\Reserva::whereRaw($rawfull)->get(); //caso COLLECTION 

        /* casos
         * reserva-nada mas todo null
         * reserva-primer input todo null
         * reserva-segundo input
         * reserva-tercera input
         * reserva-12 input
         * reserva-13 input
         * reserva-23 input
         */

        if ($tempreservable_type == null && $tempplan == null && $tempmercado == null) {
            foreach ($reservaFirst as $key => $value) {
                array_push($array1, $value);
            }
            // dd($array1); //reserva-nada mas todo null
        } else {
            if ($tempreservable_type != null && $tempplan == null && $tempmercado == null) {
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable_type == $request->reservable_type) {
                        //echo($value);
                        array_push($array1, $value);
                    }
                }
                  //dd($array1); //primer input todo null
            }
            if ($tempreservable_type == null && $tempplan != null && $tempmercado == null) {
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable->plan == $request->plan) {
                        array_push($array1, $value);
                    }
                }
                //   dd($array1); //segundo input todo null
            }
            if ($tempreservable_type == null && $tempplan == null && $tempmercado != null) {
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable->mercado_id == $request->mercado) {
                        array_push($array1, $value);
                    }
                }
                //    dd($array1); //tercero input todo null
            }

            //casos de a dos 1-2
            if ($tempreservable_type != null && $tempplan != null && $tempmercado == null) {
                $arraytemp = array();
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable_type == $request->reservable_type) {
                        array_push($arraytemp, $value);
                    }
                }
                foreach ($arraytemp as $key => $value) {
                    if ($value->reservable->plan == $request->plan) {
                        array_push($array1, $value);
                    }
                }
                //   dd($array1); //tercero input todo null
            }
            //casos de a dos 1-3
            if ($tempreservable_type != null && $tempplan == null && $tempmercado != null) {
                $arraytemp = array();
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable_type == $request->reservable_type) {
                        array_push($arraytemp, $value);
                    }
                }
                foreach ($arraytemp as $key => $value) {
                    if ($value->reservable->mercado_id == $request->mercado) {
                        array_push($array1, $value);
                    }
                }
                //   dd($array1); //tercero input todo null
            }
            //casos de a dos 2-3
            if ($tempreservable_type == null && $tempplan != null && $tempmercado != null) {
                $arraytemp = array();
                foreach ($reservaFirst as $key => $value) {
                    if ($value->reservable->plan == $request->plan) {
                        array_push($arraytemp, $value);
                    }
                }

                foreach ($arraytemp as $key => $value) {
                    if ($value->reservable->mercado_id == $request->mercado) {
                        array_push($array1, $value);
                    }
                }
                //  dd($array1); //tercero input todo null
            }
        }
        $reservas = \App\Reserva::all();
        $mercados = \App\Mercado::all();
        $instalacions = \App\Instalacion::all();
        $uebs = \App\Ueb::all();
        $collection = collect($array1);
        // dd($collection);
        return view('bloqueos.search', compact('reservas', 'uebs', 'mercados', 'instalacions', 'collection'));
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
