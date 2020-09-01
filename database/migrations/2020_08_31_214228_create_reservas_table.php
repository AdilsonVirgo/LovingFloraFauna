<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero')->default(0);
            $table->string('name');
            $table->integer('ueb_id')->default(1);
            $table->morphs('reservable');
            $table->integer('total_pax')->default(1);
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->integer('nac_id')->default(1);
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
        Schema::dropIfExists('reservas');
    }

}
