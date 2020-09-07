<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlojamientosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('alojamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('ueb_id')->default(1);
            $table->integer('capacidad');
            $table->integer('paxs')->default(0);
            $table->integer('disponibilidad')->nullable()->default(10);
            $table->integer('sencilla')->default(0);
            $table->integer('doble')->default(0);
            $table->integer('triple')->default(0);
            $table->integer('cuadruple')->default(0);
            $table->integer('albergue')->default(0);
            $table->boolean('activa')->default(true);
            $table->string('observaciones')->nullable();
            $table->timestamps();

            /* $table->foreign('instalacion_id')
              ->references('id')
              ->on('instalacions'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('alojamientos');
    }

}
