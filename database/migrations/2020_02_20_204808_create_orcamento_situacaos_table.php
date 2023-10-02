<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoSituacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento_situacaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('orcamento_id')->unsigned();
            $table->datetime('inicio')->useCurrent();
            $table->datetime('fim')->nullable()->default(NULL);

            $table->integer('status')->default(1)->comment('reference table codes (status orcamento)');
            $table->string('cadastrado_por');

            $table  ->foreign('orcamento_id')
                    ->references('id')
                    ->on('orcamentos');

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
        Schema::dropIfExists('orcamento_situacaos');
    }
}
