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
            $table->bigInteger('unidade_id')->unsigned();
            $table->integer('tipo');
            $table->bigInteger('lote_id')->nullable();
            $table->bigInteger('veiculo_id')->nullable();
            $table->string('motorista')->nullable();
            $table->string('motivo')->nullable();
            $table->string('observacao')->nullable();
            $table->datetime('data_entrada');
            $table->datetime('data_saida')->nullable();

            $table->foreign('unidade_id')
                             ->references('id')
                             ->on('unidades');
            
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
