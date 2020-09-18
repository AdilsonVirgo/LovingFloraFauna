<?php

namespace App\Http\Controllers\Reservas;

use App\ReservaCocodrilera;
use \App\Http\Controllers\Controller;
use App\Reserva;

class ReservaCocodrileraController extends Controller {

    public function index() {
        $rcocodrileras = \App\ReservaCocodrilera::all();
        return view('reservas.rcocodrileras.index', compact('rcocodrileras'));
    }

    public function create() {
        $cocodrileras = \App\Cocodrilera::all();
        $mercados = \App\Mercado::all();
        $agencias = \App\Agencia::all();
        $provincias = \App\Provincia::all();
        $uebs = \App\Ueb::all();
        $nacs = \App\Nac::all();
        return view('reservas.rcocodrileras.create',
                compact('cocodrileras', 'provincias', 'uebs', 'mercados', 'nacs', 'agencias'));
    }

    //sin agencia, ni adultos, ni menores
    public function DispoCOCO9params($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $activaForm) {
        $watchtidx = $cocodrileraForm;
        $watchtypex = "App\Cocodrilera";
        $reservablex = "App\ReservaCocodrilera";
        $plan = $planForm;
        $mercado_id = $mercadoForm;
        $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
        $name = $nameForm;
        $total_pax = $totalForm;
        $fecha_entrada = $fechaEForm;
        $fecha_salida = $fechaSForm;
        $nac_id = $nacForm;
        $activa = $activaForm;
        $observaciones = "obs";
        $alojtemp = \App\Cocodrilera::find($cocodrileraForm);
        $servicio_id = $alojtemp->servicio->id;
        if ($this->ONEDAYDISPO($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $activaForm)) {
            $retorno = ReservaCocodrilera::create(['name' => $name, 'cocodrilera_id' => $watchtidx, 'mercado_id' => $mercado_id,
                        'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,
                        'activa' => $activa, 'observaciones' => $observaciones,]);
            $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex,
                        'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada,
                        'fecha_salida' => $fecha_salida, 'nac_id' => $nac_id, 'activa' => $activa, 'observaciones' => $observaciones,]);
            $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
            $servicio_id = $serx->id;
            $reserva->servicios()->attach($servicio_id);
        } else {
            return -1;
        }
        if ($retorno) {
            return 1;
        } else {
            return 0;
        }
    }

    //sin agencia pero con adultos y menores
    public function DispoCOCO11params($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $adultos, $menores, $activaForm) {
        $watchtidx = $cocodrileraForm;
        $watchtypex = "App\Cocodrilera";
        $reservablex = "App\ReservaCocodrilera";
        $plan = $planForm;
        $mercado_id = $mercadoForm;
        $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
        $name = $nameForm;
        $total_pax = $totalForm;
        $fecha_entrada = $fechaEForm;
        $fecha_salida = $fechaSForm;
        $nac_id = $nacForm;
        $activa = $activaForm;
        $observaciones = "obs";
        $alojtemp = \App\Cocodrilera::find($cocodrileraForm);
        $servicio_id = $alojtemp->servicio->id;
        if ($this->ONEDAYDISPO($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $activaForm)) {
            $retorno = ReservaCocodrilera::create(['name' => $name, 'cocodrilera_id' => $watchtidx, 'mercado_id' => $mercado_id,
                        'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,
                        'adultos' => $adultos, 'menores' => $menores, 'activa' => $activa, 'observaciones' => $observaciones,]);
            $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex,
                        'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,
                        'nac_id' => $nac_id, 'activa' => $activa, 'observaciones' => $observaciones,]);
            $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
            $servicio_id = $serx->id;
            $reserva->servicios()->attach($servicio_id);
        } else {
            return -1;
        }
        if ($retorno) {
            return 1;
        } else {
            return 0;
        }
    }

    //con agencia ,adultos y menores
    public function DispoCOCO12params($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $adultos, $menores, $agenciaForm, $activaForm) {
        $watchtidx = $cocodrileraForm;
        $watchtypex = "App\Cocodrilera";
        $reservablex = "App\ReservaCocodrilera";
        $plan = $planForm;
        $mercado_id = $mercadoForm;
        $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
        $name = $nameForm;
        $total_pax = $totalForm;
        $fecha_entrada = $fechaEForm;
        $fecha_salida = $fechaSForm;
        $nac_id = $nacForm;
        $activa = $activaForm;
        $observaciones = "obs";
        $alojtemp = \App\Cocodrilera::find($cocodrileraForm);
        $servicio_id = $alojtemp->servicio->id;
        if ($this->ONEDAYDISPO($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $activaForm)) {
            $retorno = ReservaCocodrilera::create(['name' => $name, 'cocodrilera_id' => $watchtidx, 'mercado_id' => $mercado_id,
                        'total_pax' => $total_pax, 'plan' => $plan, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,
                        'adultos' => $adultos, 'menores' => $menores, 'agencia_id' => $agenciaForm, 'activa' => $activa, 'observaciones' => $observaciones,]);
            $reserva = Reserva::create(['name' => $name, 'ueb_id' => $ueb_id, 'reservable_type' => $reservablex,
                        'reservable_id' => $retorno->id, 'total_pax' => $total_pax, 'fecha_entrada' => $fecha_entrada, 'fecha_salida' => $fecha_salida,
                        'nac_id' => $nac_id, 'activa' => $activa, 'observaciones' => $observaciones,]);
            $serx = \DB::table('servicios')->where('watchable_type', $watchtypex)->where('watchable_id', $watchtidx)->first();
            $servicio_id = $serx->id;
            $reserva->servicios()->attach($servicio_id);
        } else {
            return -1;
        }
        if ($retorno) {
            return 1;
        } else {
            return 0;
        }
    }

    public function ONEDAYDISPO($nameForm, $cocodrileraForm, $mercadoForm, $totalForm, $nacForm, $planForm, $fechaEForm, $fechaSForm, $activaForm) {
        $watchtidx = $cocodrileraForm;
        $watchtypex = "App\Cocodrilera";
        $reservablex = "App\ReservaCocodrilera";
        $plan = $planForm;
        $mercado_id = $mercadoForm;
        $ueb_id = \App\Cocodrilera::find($watchtidx)->ueb_id;
        $name = $nameForm;
        $total_pax = $totalForm;
        $fecha_entrada = $fechaEForm;
        $fecha_salida = $fechaSForm;
        $nac_id = $nacForm;
        $activa = $activaForm;
        $observaciones = "obs";
        $nameReserva = $nameForm;
        $clienteReserva = "CLIENTE";
        $pilagente_idReserva = $total_pax;
        $first = new \Carbon\Carbon($fecha_entrada, null);
        $second = new \Carbon\Carbon($fecha_salida, null);
        $alojtemp = \App\Cocodrilera::find($cocodrileraForm);
        $servicio_id = $alojtemp->servicio->id;
        $cumpletodo = $this->PasoTodo($nameReserva, $clienteReserva, $pilagente_idReserva, $fecha_entrada, $fecha_salida, $first, $second, $servicio_id);
        return $cumpletodo;
    }

}
