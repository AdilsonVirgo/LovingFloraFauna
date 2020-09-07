<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaSenderosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reserva_senderos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique(); //localizador
            $table->integer('sendero_id');    
            $table->integer('mercado_id');
            $table->integer('total_pax')->default(1);
            $table->integer('plan')->default(0);              
            /*     $table->integer('nacionalidad_cliente_id'); */
            $table->Date('fecha_entrada');
            $table->Date('fecha_salida');
            $table->boolean('activa')->default(true);
            $table->string('observaciones')->nullable();
            $table->timestamps();
            
           /* $table->foreign('sendero_id')
                    ->references('id')
                    ->on('senderos');
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
        Schema::dropIfExists('reserva_senderos');
    }

}
