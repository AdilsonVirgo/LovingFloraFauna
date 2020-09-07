<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaPescasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reserva_pescas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //alias localizador
            $table->integer('pesca_id');
            $table->integer('mercado_id');
            $table->integer('total_pax')->default(1);
            $table->integer('plan')->default(0);
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->boolean('activa')->default(true);
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('reserva_pescas');
    }

}
