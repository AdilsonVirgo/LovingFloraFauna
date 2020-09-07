<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva_servicio', function (Blueprint $table) {
            $table->primary(['reserva_id','servicio_id']);
            $table->unsignedInteger('reserva_id');
            $table->unsignedInteger('servicio_id');
           /* $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            */$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva_servicio');
    }
}
