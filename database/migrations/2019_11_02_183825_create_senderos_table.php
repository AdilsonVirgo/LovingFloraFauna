<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('senderos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
             $table->integer('ueb_id')->default(1);
            $table->integer('capacidad');
            $table->integer('paxs')->default(0); //actualmente
            $table->integer('disponibilidad')->default(10);
            $table->boolean('activa')->default(true);
            $table->string('observaciones')->nullable();
            $table->timestamps();
            
          /*  $table->foreign('provincia_id')
                    ->references('id')
                    ->on('provincias');
            $table->foreign('ueb_id')
                    ->references('id')
                    ->on('uebs');*/
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('senderos');
    }

}
