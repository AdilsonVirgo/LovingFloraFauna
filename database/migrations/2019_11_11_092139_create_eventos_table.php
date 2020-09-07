<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('ueb_id')->default(1);
            $table->integer('capacidad')->default(1);
            $table->integer('paxs')->default(0); //actualmente
            $table->integer('disponibilidad')->default(10);
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
        Schema::dropIfExists('eventos');
    }

}
