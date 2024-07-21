<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('area', 191)->collation('utf8mb4_unicode_ci');
            $table->date('data_inicio');
            $table->string('limpeza', 191)->collation('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('unidade_id');
            $table->timestamps();
            $table->string('status', 191)->collation('utf8mb4_unicode_ci')->default('Pendente');
            $table->string('acessorios', 191)->collation('utf8mb4_unicode_ci')->default('N/A');
            $table->string('celular_responsavel', 20)->collation('utf8mb4_unicode_ci');
            $table->dateTime('dt_entrega_chaves')->nullable();
            $table->string('retirado_por', 100)->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('dt_devolucao_chaves')->nullable();
            $table->string('devolvido_por', 100)->collation('utf8mb4_unicode_ci')->nullable();

            // Índices e chaves estrangeiras (se necessário)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
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
