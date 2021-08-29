<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin');       //Puerto de origen
            $table->string('destination');  //Puerto de destino
            $table->string('currency');     //Moneda
            $table->string('twenty');       //Monto de contenedor por tipo 20'GP
            $table->string('forty');        //Monto de contenedor por tipo 40'GP
            $table->string('fortyhc');      //Monto de contenedor por tipo 40'HG

            $table->bigInteger('contract_id')->unsigned(); //Relacion con table contratos

            $table->timestamps();

            /**
             * Clave foranea que relaciona las rutas con los contratos
             */
            $table->foreign('contract_id')
                    ->references('id')
                    ->on('contracts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
