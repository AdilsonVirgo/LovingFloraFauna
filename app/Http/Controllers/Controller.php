<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Servicio;
use App\Reserva;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\dispolist;
use \Illuminate\Support\Arr;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    /* TODO LO QUE SE HABIA PENSADO */

    public function CumpleTodo($param) {//vienen todos los parametros incluido el servicio
        $datosiniciales = $this->capturartodoyconvertir($param); //request

        $array_fechas = $this->Dias2Fechas($datosiniciales[3], $datosiniciales[4]); //first and second fechaentra y fechasalida

        return $this->recorrerfechas($array_fechas, $datosiniciales);
    }

    public function capturartodoyconvertir($request) {
        $nameReserva = $request->get('name'); //array[0]
        $clienteReserva = "CLIENTE"; //array[1]
        $pilagente_idReserva = $request->get('total_pax'); //array[2]
        $fecha_entrada = $request->get('fecha_entrada'); //array[3]
        $fecha_salida = $request->get('fecha_salida'); //array[4]
        // $first = new Carbon\Carbon($fecha_entrada, null); //array[5]//CARBON1
        // $second = new Carbon\Carbon($fecha_salida, null); //array[6]
        $first = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_entrada); //CARBON2
        $second = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_salida);
        $alojamiento_idReserva = $request->get('servicio_id'); //array[7]//alojamiento_id
        $array = array($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $alojamiento_idReserva);
        return $array;
    }

    public function Dias2Fechas($fecha_entrada, $fecha_salida) {//esto se puede mejorar //parametro fecha sin carbon      
        //$f1 = new Carbon\Carbon($fecha_entrada, null);
        // $f2 = new Carbon\Carbon($fecha_salida, null);
        $f1 = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_entrada);
        $f2 = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_salida);

        $fecha1 = $f1->copy();
        $fecha2 = $f2->copy();
        $fechasArray = null;
        $i = 0;
        if ($fecha1->equalTo($fecha2)) {
            $fechasArray = Arr::add($fechasArray, $i, $fecha1->copy());
        } else {
            while ($fecha1->notEqualTo($fecha2)) {
                $fechasArray = Arr::add($fechasArray, $i, $fecha1->copy());
                $fecha1->addDays(1);
                $i++;
            }
        }
        return Arr::flatten($fechasArray);
    }

    public function DiasUpFechas($carbonfe1, $carbonfs1) {//pasalas carbon
        $array_fechas = array();
        $entero = $carbonfe1->diffInDays($carbonfs1);
        for ($i = 0; $i < $entero; $i++) {
            array_push($array_fechas, $carbonfe1->copy());
            $carbonfe1->addDay();
        }
        return $array_fechas;
    }

    public function recorrerfechas($array_fechas, $datosiniciales) {
        $array_booleans = null;
        $i = 0;
        foreach ($array_fechas as $currentdate) {
            $encontreOnull = $this->DameDatosdeBDEstaFecha($currentdate, $datosiniciales[7]); //servicioid
            $array_booleans = Arr::add($array_booleans, $i, $this->condicion2CompararDispoAlojamientoconDatosIniciales($encontreOnull, $datosiniciales));
            $i++;
        }
        $collection = collect($array_booleans);
        $eve = $collection->every(function ($value, $key) {
            return $value == true;
        });
        // return $eve;
        if ($eve) {//si es verdadero se pueden insertar
            foreach ($array_fechas as $currentdate) {
                $encontreOnull = $this->DameDatosdeBDEstaFecha($currentdate, $datosiniciales[7]); //comparar si es null el alojamiento
                //$array_booleans = Arr::add($array_booleans, $i, $this->condicion2CompararDispoAlojamientoconDatosIniciales($encontreOnull, $datosiniciales));
                //$i++;  dd($datosiniciales);
                $this->condicion3Insertar($encontreOnull, $datosiniciales, $currentdate);
            }//$this->condicion3Insertar($encontreOnull, $datosiniciales, $currentdate); //se recorre la fechas enteras y se inserta y se rebaja las dispo y actualizan las fechas
            return true;
        } else {
            //echo 'FORGET IT';
            return false;
            //dd($eve); //si es falso no se puede insertar esta reserva
        }
        // dd($i);
    }

    public function DameDatosdeBDEstaFecha($currentdate, $servicio_id) {
        return \DB::table('dispolists')->where([
                    ['fecha', $currentdate],
                    ['servicio_id', '=', $servicio_id],
                ])->first();
    }

    public function condicion2CompararDispoAlojamientoconDatosIniciales($encontreOnull, $datosiniciales) {//en el dia actual compara dispo
        $afind = Servicio::find($datosiniciales[7]); //id->alojamiento      
        // dd($afind->watchable->disponibilidad);
        //dd($encontreOnull);
        if ($this->condicion1Null($encontreOnull)) {//encontre
            if ($afind->watchable->disponibilidad >= $datosiniciales[2]) {//$afind->watchable->disponibilidad
                return true;
            }
        } else {
            if ($encontreOnull->disponibilidad >= $datosiniciales[2]) {//$pilagente_idReserva///totalpax
                return true;
            }
        }
        return false; //echo('no hay dispo');
    }

    public function condicion1Null($param) {//consultaxfecha la fecha no esta en BD
        if ($param === null) {
            return true;
        }
        return false;
    }

    public function condicion3Insertar($encontreOnull, $datosiniciales, $currentdate) {
        $afind = Servicio::find($datosiniciales[7]); //id_servicio     
        $aux = $datosiniciales[2]; //se perdia la referencia
        if ($encontreOnull === null) {//encontre
            if ($afind->watchable->disponibilidad >= $aux) {//return true;insertar cuando dispo sirve y la fecha no esta          
                //echo($currentdate->toDateString() );  
                $this->AddDispoReal($datosiniciales, $currentdate);
            }
        } else {

            if ($encontreOnull->disponibilidad >= $aux) {// return true;update cuando la fecha esta        //echo('entre encontr:ok');
                $this->UpdateDispoReal($currentdate, $datosiniciales);
            }
        }
        return false;
    }

    public function AddDispoReal($datosiniciales, $currentdate) {

        $afind = \App\Servicio::find($datosiniciales[7]); //idservicio
        $mismoname = $datosiniciales[0];
        $mismo_id = $datosiniciales[7];
        $nuevadiarioreal = $datosiniciales[2]; // este es adicionar no existia nada en esa fecha //no pega $afind->paxs +.....$datosiniciales[2];
        $nuevadispo = $afind->capacidad - $datosiniciales[2]; //lo mismo
        $mismafecha = $currentdate->toDateString();
        $att2 = [
            'name' => $mismoname,
            'servicio_id' => $mismo_id, //servicioid
            'diarioreal' => $nuevadiarioreal,
            'disponibilidad' => $nuevadispo,
            'fecha' => $mismafecha,
        ];        //dd($att2);
        $added = tap(new Dispolist($att2))->save();
        return $added;
    }

    public function UpdateDispoReal($currentdate, $datosiniciales) {
        $encontre = $this->DameDatosdeBDEstaFecha($currentdate, $datosiniciales[7]);
        $mismoid = $encontre->id;
        $mismoname = $datosiniciales[0];
        $mismoalojamiento_id = $encontre->servicio_id;
        $nuevadispo = $encontre->disponibilidad - $datosiniciales[2];
        $nuevadiarioreal = $encontre->diarioreal + $datosiniciales[2];
        $mismafecha = $currentdate;
        $att2 = [
            'name' => $mismoname,
            'servicio_id' => $mismoalojamiento_id,
            'diarioreal' => $nuevadiarioreal,
            'disponibilidad' => $nuevadispo,
            'fecha' => $mismafecha,
        ];
        $updated = \DB::table('dispolists')
                ->where('id', $mismoid)
                ->update($att2);
        return $updated;
    }

    /* IMPROVED */

    public function PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $alojamiento_idReserva) {//aqui le paso yo los parametros
        $datosiniciales = array($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $alojamiento_idReserva);

        $array_fechas = $this->Dias2Fechas($datosiniciales[3], $datosiniciales[4]); //first and second fechaentra y fechasalida

        return $this->recorrerfechas($array_fechas, $datosiniciales);
    }

}
