<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocodrilerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cocodrileras', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->integer('ueb_id')->default(1);
            $table->integer('capacidad');
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
    public function down()
    {
        Schema::dropIfExists('cocodrileras');
    }
}
