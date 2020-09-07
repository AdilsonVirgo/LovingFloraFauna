<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaAlojamientosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reserva_alojamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //alias localizador
            $table->integer('alojamiento_id');
            $table->integer('mercado_id');
            $table->integer('total_pax')->default(1);
            $table->integer('sencilla')->default(0);
            $table->integer('doble')->default(0);
            $table->integer('triple')->default(0);
            $table->integer('cuadruple')->default(0);
            $table->integer('albergue')->default(0);
            $table->integer('plan')->default(0); 
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->boolean('activa');
            $table->string('observaciones')->nullable();
            $table->timestamps();
            
           /* $table->foreign('alojamiento_id')
                    ->references('id')
                    ->on('alojamientos');
            $table->foreign('mercado_id')
                    ->references('id')
                    ->on('mercados');*/
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('reserva_alojamientos');
    }

}
