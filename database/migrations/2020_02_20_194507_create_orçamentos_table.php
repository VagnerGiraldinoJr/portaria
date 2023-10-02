<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrçamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();

            $table->decimal('valor',10,2);
            $table->decimal('acrescimo',10,2);
            $table->decimal('desconto',10,2);
            $table->decimal('valor_total',10,2);
            $table->integer('forma_pagamento')->comment('reference table codes');

            $table->date('data_entrega');
            $table->datetime('data_hora')->useCurrent();
            $table->string('cadastrado_por');
            $table  ->foreign('cliente_id')
                    ->references('id')
                    ->on('clientes');
            $table->softDeletes();
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
        Schema::dropIfExists('orçamentos');
    }
}
