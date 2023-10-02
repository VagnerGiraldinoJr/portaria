<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('orcamento_id')->unsigned();
            $table->bigInteger('produto_id')->unsigned();
            $table->decimal('quantidade',10,2);
            $table->decimal('valor',10,2);

            $table  ->foreign('produto_id')
                    ->references('id')
                    ->on('produtos');

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
        Schema::dropIfExists('itens_orcamentos');
    }
}
