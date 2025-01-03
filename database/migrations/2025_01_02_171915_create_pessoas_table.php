<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_completo');
            $table->string('celular')->nullable();
            $table->string('rg')->nullable();
            $table->string('tipo')->nullable();
            $table->string('desc_tipo')->nullable();
            $table->unsignedBigInteger('lote_id'); // Chave estrangeira

            // Relacionamento com a tabela 'lotes'
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');

            $table->timestamps(); // Cria 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
