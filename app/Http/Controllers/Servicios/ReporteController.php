<?php

namespace App\Http\Controllers\Servicios;

use App\Reporte;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class ReporteController extends Controller {

    public function JSON() {
        Try {
            $reportes = \App\Reporte::all();
            //$provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json($reportes->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['reportes' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $reportes = \App\Reporte::all(); //->sortByDesc('id') ;
        $reservas = \App\Reserva::all(); //->sortByDesc('id') ;
        $reservascount = count($reservas);
        $ra = $reservas->first();
        // dd($ra->reservable_type);
        //2 tipos de reserva RA y RS
        $array_names = [];
        $array_counts = [];
        array_push($array_names, 'App\ReservaAlojamiento');//pos0
        array_push($array_names, 'App\ReservaCocodrilera');
        array_push($array_names, 'App\ReservaEcuestre');
        array_push($array_names, 'App\ReservaEvento');
        array_push($array_names, 'App\ReservaExcursion');//pos4
        array_push($array_names, 'App\ReservaFluvial');
        array_push($array_names, 'App\ReservaGastronomia');
        array_push($array_names, 'App\ReservaNautica');
        array_push($array_names, 'App\ReservaObs');//pos8
        array_push($array_names, 'App\ReservaOferta');
        array_push($array_names, 'App\ReservaPesca');
        array_push($array_names, 'App\ReservaSafari');
        array_push($array_names, 'App\ReservaSendero');//pos12
        array_push($array_names, 'App\ReservaValla');

        for ($i = 0; $i < count($array_names); $i++) {
            array_push($array_counts, 0);
        }//dd($array_counts);
        for ($i = 0; $i < count($reservas); $i++) {
           
         //   if ($reservas->toArray()[$i]['reservable_type'] === 'App\ReservaAlojamiento') {
            if ($reservas[$i]->reservable_type === 'App\ReservaAlojamiento') {
                $var = $array_counts[0];
                $var++;
                $array_counts[0] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaCocodrilera') {
                $var = $array_counts[1];
                $var++;
                $array_counts[1] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaEcuestre') {
                $var = $array_counts[2];
                $var++;
                $array_counts[2] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaEvento') {
                $var = $array_counts[3];
                $var++;
                $array_counts[3] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaExcursion') {
                $var = $array_counts[4];
                $var++;
                $array_counts[4] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaFluvial') {
                $var = $array_counts[5];
                $var++;
                $array_counts[5] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaGastronomia') {
                $var = $array_counts[6];
                $var++;
                $array_counts[6] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaNautica') {
                $var = $array_counts[7];
                $var++;
                $array_counts[7] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaObs') {
                $var = $array_counts[8];
                $var++;
                $array_counts[8] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaOferta') {
                $var = $array_counts[9];
                $var++;
                $array_counts[9] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaPesca') {
                $var = $array_counts[10];
                $var++;
                $array_counts[10] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaSafari') {
                $var = $array_counts[11];
                $var++;
                $array_counts[11] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaSendero') {
                $var = $array_counts[12];
                $var++;
                $array_counts[12] = $var;
            }
            if ($reservas[$i]->reservable_type === 'App\ReservaValla') {
                $var = $array_counts[13];
                $var++;
                $array_counts[13] = $var;
            }
        }
           
        if ($reservascount > 0) {
            return view('reportes.index', compact('reportes', 'reservas', 'reservascount', 'array_counts'));
        } else {
            return redirect()->back();
        }
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
     * @param  \App\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function show(Reporte $reporte) {
         return view('reportes.show', compact($reporte, 'reporte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Reporte $reporte) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reporte $reporte) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporte $reporte) {
        //
    }

}
