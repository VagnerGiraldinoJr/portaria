<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControleAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controle_acessos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tipo');
            $table->integer('pessoa_id')->nullable();
            $table->integer('veiculo_id')->nullable();
            $table->string('motorista')->nullable();
            $table->datetime('data_entrada');
            $table->datetime('data_saida')->nullable();
            $table->string('observacao');
            $table->string('motivo');
            $table->string('destino')->nullable();
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
        Schema::dropIfExists('controle_acessos');
    }
}
