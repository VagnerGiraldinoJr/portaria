<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reservas'); // Remove a tabela existente, se houver

        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id'); // Cria a chave primária 'id'
            $table->unsignedBigInteger('user_id'); // FK para 'users' table
            $table->string('area', 191);
            $table->date('data_inicio');
            $table->string('limpeza', 191);
            $table->unsignedBigInteger('unidade_id'); // FK para 'unidades' ou 'lotes' (definido corretamente depois)
            $table->unsignedBigInteger('lote_id')->nullable(); // FK para 'lotes' table
            $table->string('status', 191)->default('Pendente');
            $table->string('acessorios', 191)->default('N/A');
            $table->string('celular_responsavel', 20);
            $table->timestamp('dt_entrega_chaves')->nullable();
            $table->string('retirado_por', 100)->nullable();
            $table->timestamp('dt_devolucao_chaves')->nullable();
            $table->string('devolvido_por', 100)->nullable();
            $table->timestamps(); // Cria os campos 'created_at' e 'updated_at'

            // Definição das chaves estrangeiras
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade'); // Ajustar conforme necessário
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas'); // Remove a tabela caso a migração seja revertida
    }
}
