<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{

    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('area');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->string('limpeza');
            $table->unsignedBigInteger('unidade_id');

            // Definindo a chave estrangeira
            $table->foreign('unidade_id')->references('id')->on('lotes');
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
        Schema::dropIfExists('reservas');
    }
}
