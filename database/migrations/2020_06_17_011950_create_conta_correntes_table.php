<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaCorrentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_correntes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('caixa_id')->unsigned(); // FOREING KEY
            $table->decimal('valor',10,2);
            $table->integer('operacao')->nullable()->comment('reference table codes');
            $table->integer('forma_pagamento')->comment('reference table codes');
            
            $table->datetime('data_hora')->useCurrent();
            $table->string('cadastrado_por');
            $table->string('referencia',30)->nullable()->default('');
            $table->integer('pedido_id')->nullable()->default(0);

            $table->integer('extornado')->nullable()->default(0);
            $table->text('motivo_extorno');
            
            $table->integer('fechado')->default(0);
            $table->string('fechado_por');
            
            $table  ->foreign('caixa_id')
                    ->references('id')
                    ->on('caixas');

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
        Schema::dropIfExists('conta_correntes');
    }
}
