<?php

namespace App\Http\Controllers\Servicios;

use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Http\Controllers\Controller;

class InfoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $alojfulltemp = null;
        $fecha_entradatemp = '';
        $fecha_salidatemp = '';
        $collection = collect([]);
        $ralojamientos = \App\ReservaAlojamiento::all();
        $alojamientos = \App\Alojamiento::all();
        $turistas_fisicos = 0;
        $turistas_dias = 0;
        $densidad_ocupacional = 0;
        $estancia_media = 0; //estancia media          
        $indice_ocup = 0; //indice de ocupacion
        $parcialTuristasFisicos = array();
        $parcialTuristasDias = array();
        $parcialesDensidadOcup = array();
        $parcialesEstanciaMedia = array();
        $parcialesIndiceOcupacional = array();

        return view('infos.index', compact('alojfulltemp', 'fecha_entradatemp', 'fecha_salidatemp', 'ralojamientos', 'alojamientos', 'turistas_fisicos', 'turistas_dias', 'estancia_media', 'densidad_ocupacional', 'indice_ocup', 'parcialTuristasFisicos', 'parcialTuristasDias', 'parcialesDensidadOcup', 'parcialesEstanciaMedia', 'parcialesIndiceOcupacional'));
    }

    public function search(Request $request) {
        $ralojamientos = \App\ReservaAlojamiento::all();
        $alojamientos = \App\Alojamiento::all();
        $diariotemp;
        $dispotemp;
        $habocuptemp;
        $habdisptemp;
        $rawfull = "";
        $consulta = "activa = 1 ";
        $rawfull = $rawfull . $consulta;
        $alojtemp = $request->alojamiento_id;
        $fecha_entradatemp = $request->fecha_entrada;
        $fecha_salidatemp = $request->fecha_salida;

        $turistas_dias = 0; //$turistas_fisicos es turistas fisicas * dias
        $porciento_ocupacion = 0; //$porciento_ocupacion es turistas dias / cantHabOcupadasxReserva
        $estancia_media = 0; //estancia media es $calctemp / $value->total_pax;
        $indice_ocup = 0; //indice de ocupacion es  Habitaciones dia Ocupadas / Habitaciones dias Disponibles ) por 100
        $parcial = array();
        $parciales = array();
        $parcialesOcupadas = array();
        $parcialesestanciamedia = array();
        $parcialesindiceocup = array();

        if ($alojtemp) {
            $consulta = " AND alojamiento_id = " . "'" . $request->alojamiento_id . "'";
            $rawfull = $rawfull . $consulta;
        }
        if ($fecha_entradatemp) {
            $consulta = " AND fecha_entrada >= " . "'" . $request->fecha_entrada . "'"; //request es RE
            $rawfull = $rawfull . $consulta;
        }
        if ($fecha_salidatemp) {
            $consulta = " AND fecha_salida <= " . "'" . $request->fecha_salida . "'";
            $rawfull = $rawfull . $consulta;
        }
        ///calculo de la reserva especifica en esta fechas y de este alojamiento
        $collection = \App\ReservaAlojamiento::whereRaw($rawfull)->get();
        dd($collection);
        $alojfulltemp = \App\Alojamiento::find($alojtemp);
        $formatSDate = date("Y-m-d", strtotime($request->fecha_entrada));
        $formatEDate = date("Y-m-d", strtotime($request->fecha_salida));
        $carbonfe1 = new \Carbon\Carbon($formatSDate);
        $carbonfs1 = new \Carbon\Carbon($formatEDate);
        $array_fechas = $this->Dias2Fechas($carbonfe1, $carbonfs1);
        //  dd($alojfulltemp->servicio->dispolists);
        //dd($array_fechas);         //dd($alojfulltemp->reservaalojamiento);        
        foreach ($array_fechas as $key => $currentdate) {
            $encontreOnull = $this->DameDatosdeBDEstaFecha($currentdate, $alojfulltemp->servicio->id);
            //dd($encontreOnull);//reservaid, name, servicio,diario,dispo,fecha
            if ($encontreOnull === null) {
                $diariotemp = 0;
                $dispotemp = $alojfulltemp->capacidad;
                $habocuptemp = 0;
                $habdisptemp = $alojfulltemp->capacidad;
            } else {
                $diariotemp = $encontreOnull->diarioreal;
                $dispotemp = $encontreOnull->disponibilidad;
                //  dd($currentdate); //dia 4                
                //OK el de abajo no es solo una muestra de un camino diferent // dd($alojfulltemp->servicio->reservas->where('fecha_entrada', '<=', $currentdate)->where('fecha_salida', '>=', $currentdate));
                //dd($alojfulltemp->reservaalojamientos->where('fecha_salida','>=', $currentdate)); //dos formas diferentes
                $ra = $alojfulltemp->servicio->reservas->where('fecha_entrada', '<=', $currentdate)->where('fecha_salida', '>=', $currentdate)->first(); //el primero q cumpla
                // dd($ra->reservable);
                $habocuptemp = $this->cantHabOcupadasxReserva($ra->reservable); //reserva especifica

                $habdisptemp = $alojfulltemp->servicio->capacidad - $habocuptemp;
            }
            $what = ($habocuptemp / $habdisptemp) * 100; //puse what porque no se cual es la palabrra
            array_push($parcialesindiceocup, $what);
        }
        //dd($parcialesindiceocup);
        if ($collection->count() == 0) {
            $turistas_fisicos = 0;

            return view('infos.index', compact('parcial', 'ralojamientos', 'alojamientos', 'collection', 'turistas_fisicos', 'turistas_dias', 'porciento_ocupacion', 'indice_ocup', 'parciales', 'parcialesOcupadas', 'parcialesestanciamedia', 'parcialesindiceocup', 'estancia_media'));
        } else {
            $turistas_fisicos = $collection->sum('total_pax');

            foreach ($collection as $key => $value) {//reserva actual     
                $formatStartDate = date("Y-m-d", strtotime($value->fecha_entrada));
                $formatEndDate = date("Y-m-d", strtotime($value->fecha_salida));
                $carbonfe = new \Carbon\Carbon($formatStartDate);
                $carbonfs = new \Carbon\Carbon($formatEndDate);
                $calctemp = $carbonfs->diffInDays($carbonfe) * $value->total_pax; //turistas dias
                $estancia_media_parcial = $calctemp / $value->total_pax;

                array_push($parcial, $value->total_pax);
                array_push($parciales, $calctemp);
                array_push($parcialesOcupadas, $calctemp / $this->cantHabOcupadasxReserva($value));
                array_push($parcialesestanciamedia, $estancia_media_parcial);
            }
            $turistas_dias = collect($parciales)->sum();
            $porciento_ocupacion = collect($parcialesOcupadas)->avg();
            $indice_ocup = collect($parcialesindiceocup)->avg();
            $estancia_media = $turistas_dias / $turistas_fisicos;

            return view('infos.index', compact('parcial', 'ralojamientos', 'alojamientos', 'collection', 'turistas_fisicos', 'turistas_dias', 'porciento_ocupacion', 'indice_ocup', 'parcialesindiceocup', 'parciales', 'parcialesOcupadas', 'parcialesestanciamedia', 'estancia_media'));
        }
    }

    public function searchXFechas(Request $request) {
        /*
         * recibe las fechas y el alojamiento (no es temporal este es UNICO)
         * busca el servicio asociado y las reservas generales de ese servicio // pueden ser miles
         * ir fecha a fecha de las pedidas y
         *  recorrerlas y comparar si esa fecha cumple con estar en alguna d elas reservaciones
         * guarda las busquedas en ese rango en un arreglo LISTO
         * Buscar turistas consumiendo HOY
         * para buscar el turista fisico es mejor buscarlox reservas
         * falta la estancia media  $turistas_dias / $turistas_fisicos;
         * calculado la estancia media y el indice completo x dias ahora SIIIII
         *     */

        $ralojamientos = \App\ReservaAlojamiento::all();
        $alojamientos = \App\Alojamiento::all();
        $alojtemp = $request->alojamiento_id;
        $alojfulltemp = \App\Alojamiento::find($alojtemp);
        $fecha_entradatemp = $request->fecha_entrada;
        $fecha_salidatemp = $request->fecha_salida;

        $servicio = $alojfulltemp->servicio;
        $reservas = $alojfulltemp->servicio->reservas; //4

        $formatSDate = date("Y-m-d", strtotime($fecha_entradatemp));
        $formatEDate = date("Y-m-d", strtotime($fecha_salidatemp));
        $carbonfe1 = new \Carbon\Carbon($formatSDate);
        $carbonfs1 = new \Carbon\Carbon($formatEDate);
        $array_fechas = $this->DiasUpFechas($carbonfe1, $carbonfs1);
        $nolevel = array();

        $arregloDreservasXDias = array();
        $arregloDeReservasXFecha = array();
        $turistasfisicosConsumiendo = array();
        $arrayunico = array();
        $reservasUnicas = collect($arrayunico); //Collection

        $diariotemp = 0;
        $dispotemp = 0;
        $habocuptemp = 0;
        $habdisptemp = 0;
        $parcialesindiceocup = array();
        $parcialesDensidadOcup = array();

        foreach ($array_fechas as $key => $currentdate) {
            $encontreOnull = $this->DameDatosdeBDEstaFecha($currentdate->format('Y-m-d'), $alojfulltemp->servicio->id);

            array_push($arregloDreservasXDias, $encontreOnull);
            if ($encontreOnull === null) {
                array_push($turistasfisicosConsumiendo, 0);
            } else {
                array_push($turistasfisicosConsumiendo, $encontreOnull->diarioreal);
            }
            $collection = $this->reservasQueIncluyenESTAFecha($reservas, $currentdate); //mas de un resultado y resuelto por varias vias :)
            array_push($arregloDeReservasXFecha, $collection);
            foreach ($reservas as $x => $data) {
                $f1 = new Carbon($data->fecha_entrada, null);
                $f2 = new Carbon($data->fecha_salida, null);
                if ($currentdate->between($f1, $f2)) {
                    array_push($nolevel, $data); //revisar si queda aqui
                    if (!$reservasUnicas->contains($data)) {
                        $reservasUnicas->push($data);
                    }
                }
            }
            if ($encontreOnull === null) {
//                echo('$currentdate' . $currentdate);
//                echo('<br/>');
//                echo('<br/>');
                $diariotemp = 0;
                $dispotemp = $alojfulltemp->capacidad;

                $habocuptemp = 0;
                $habdisptemp = $alojfulltemp->capacidad;
                $do = 0;
                //   dd($habocuptemp);
                $what = ($habocuptemp / $habdisptemp) * 100; //puse what porque no se cual es la palabrra
                array_push($parcialesindiceocup, $what);
                array_push($parcialesDensidadOcup, $do);
            } else {
                // dd($encontreOnull);
                array_push($nolevel, $data); //revisar si queda aqui
                $diariotemp = $encontreOnull->diarioreal;

                $dispotemp = $encontreOnull->disponibilidad;

                $ra = $alojfulltemp->servicio->reservas->where('fecha_entrada', '<=', $currentdate)
                        ->where('fecha_salida', '>', $currentdate); //mas de un resultado y resuelto por varias vias :)
                //dd($ra);
                $sumatoria = 0;
                $sumatoriad = 0;
                $sumatoriapersonalfisicoesedia = 0;

                // for ($i = 0; $i < count($ra); $i++) {
                foreach ($ra as $i => $dato) {

//                    echo('$currentdate' . $currentdate);
//                    echo('<br/>');
//                    echo('reserva' . $ra[$i]->reservable);
//                    echo('<br/>');
//
//                    echo('cant personas' . $ra[$i]->reservable->total_pax);
//                    echo('<br/>');
                    $habocuptemp = $ra[$i]->reservable->sencilla + $ra[$i]->reservable->doble + $ra[$i]->reservable->triple + $ra[$i]->reservable->cuadruple + $ra[$i]->reservable->albergue;
                    $habdisptemp = $alojfulltemp->servicio->capacidad - $habocuptemp;
//                    echo('cant hab ocupadas ' . $habocuptemp);
//
//                    echo('<br/>');
//                    echo('cant hab disponibles ' . $habdisptemp);
                    $sumatoria = $sumatoria + $habocuptemp;
                    $sumatoriad = $sumatoriad + $habdisptemp;
                    $sumatoriapersonalfisicoesedia = $sumatoriapersonalfisicoesedia + $ra[$i]->reservable->total_pax;
//                    echo('<br/>');
//                    echo('variable $i:' . $i);
//
//                    echo('<br/>');
//                    echo('suma ocupadas:' . $sumatoria);
//                    echo('<br/>');
//                    echo('suma disponibles:' . $sumatoriad);
//                    echo('<br/>');
//                    echo('suma fisicos ese dia:' . $sumatoriapersonalfisicoesedia);
//                    echo('<br/>');
                    $do = $sumatoriapersonalfisicoesedia / $sumatoria;
//                    echo('densidad ocupacional ese dia:' . $do);//Densidad CALCULADO ESE DIA
//                    echo('<br/>');
                }
                if ($sumatoriad != 0) {
                    $lo = ($sumatoria / $sumatoriad) * 100; //indice ocupacional calculado ese dia
                } else {
                    $lo = 0;
                }
                array_push($parcialesindiceocup, $lo);
                array_push($parcialesDensidadOcup, $do); //todas las densidades
            }
        }
        // dd($collection);
        // dd($parcialesindiceocup);
        //dd($reservasUnicas->sum('total_pax'));// ya tento el turista fisico LISTO
        //dd($arregloDeReservasXFecha); //todas las reservas x dia en un servicio
        //dd($reservas); //todas las reservas de un servicio sin dias todas las que hay
        //dd($turistasfisicosConsumiendo); //turistas dias en el rango de fechas desglozado x dias
        // dd($arregloDreservasXDias); //diario dispolists x dias en ese alojamiento
        //dd(collect($turistasfisicosConsumiendo)->sum());//turistas dias en esa fechas LISTO
        //   dd(collect($turistasfisicosConsumiendo)->sum() / $reservasUnicas->sum('total_pax')); //estancia media LISTO
        //$indice_ocup = collect($parcialesindiceocup)->avg(); //LISTO INDICE OCUPACIONAL LISTO
        // dd($parcialesDensidadOcup);
        // dd($parcialesindiceocup);
        $parcialesEstanciaMedia = 0;
        $colle = collect($reservasUnicas);
        $plucked = $colle->pluck('total_pax');
        $parcialTuristasFisicos = $plucked->all();

        $parcialesIndiceOcupacional = $parcialesindiceocup;
        $turistas_fisicos = $reservasUnicas->sum('total_pax');
        $turistas_dias = collect($turistasfisicosConsumiendo)->sum();
        $parcialTuristasDias = $turistasfisicosConsumiendo;
        if ($turistas_fisicos != 0) {
            $estancia_media = $turistas_dias / $turistas_fisicos;
        } else {
            $estancia_media = 0;
        }
        $indice_ocup = collect($parcialesindiceocup)->avg();
        if(collect($parcialesDensidadOcup)->sum() == 0){$densidad_ocupacional = 0;}else{
        $densidad_ocupacional = $turistas_dias / collect($parcialesDensidadOcup)->sum(); //turistas promediado/densidad promediado
        }return view('infos.index', compact('alojfulltemp', 'fecha_entradatemp', 'fecha_salidatemp', 'ralojamientos', 'alojamientos', 'turistas_fisicos', 'turistas_dias', 'estancia_media', 'densidad_ocupacional', 'indice_ocup', 'parcialTuristasFisicos', 'parcialTuristasDias', 'parcialesDensidadOcup', 'parcialesEstanciaMedia', 'parcialesIndiceOcupacional'));
    }

    protected function cantHabOcupadasxReserva($current) {//current es reserva
        $countHab = 0;
        if ($current->sencilla != 0) {
            $countHab = $countHab + $current->sencilla;
        }
        if ($current->doble != 0) {
            $countHab = $countHab + $current->doble;
        }
        if ($current->triple != 0) {
            $countHab = $countHab + $current->triple;
        }
        if ($current->cuadruple != 0) {
            $countHab = $countHab + $current->cuadruple;
        }
        if ($current->albergue != 0) {
            $countHab = $countHab + $current->albergue;
        }
        return $countHab;
    }

    protected function reservasQueIncluyenESTAFecha($reservas, $fecha) {
        $reservasEspecifica = array();
        foreach ($reservas as $index => $data) {
            $f1 = new Carbon($data->fecha_entrada, null);
            $f2 = new Carbon($data->fecha_salida, null);
            if ($fecha->between($f1, $f2)) {
                array_push($reservasEspecifica, $data);
            }
        }
        return $reservasEspecifica;
    }

    protected function reservasUnicasXFechaBusqueda($reservas, $fecha) {
        $unicos = array();
        $collection = collect($unicos);
        foreach ($reservas as $index => $data) {
            $f1 = new Carbon($data->fecha_entrada, null);
            $f2 = new Carbon($data->fecha_salida, null);
            if ($fecha->between($f1, $f2)) {

                if (!$collection->contains($data->id)) {
                    $collection->push($data->id);
                }
            }
        }
        return $collection;
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
