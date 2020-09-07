<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePescasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pescas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('ueb_id')->default(1);
            $table->integer('capacidad');
            $table->integer('paxs')->default(0); //actualmente
            $table->integer('disponibilidad')->default(10);
            $table->string('lugar');
            $table->string('embarcacion');
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
        Schema::dropIfExists('pescas');
    }

}
