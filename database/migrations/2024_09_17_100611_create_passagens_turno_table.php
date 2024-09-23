<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassagensTurnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passagens_turno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');  // Referência ao porteiro (users)
            $table->unsignedBigInteger('unidade_id');  // Referência ao condomínio (unidades)
            $table->dateTime('inicio_turno');  // Data/hora de início do turno
            $table->dateTime('fim_turno');  // Data/hora de fim do turno
            $table->json('itens');  // Armazena os itens de controle (chaves, rádios, etc)
            $table->text('ocorrencias')->nullable();  // Campo de ocorrências
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
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
        Schema::dropIfExists('passagens_turno');
    }
}
