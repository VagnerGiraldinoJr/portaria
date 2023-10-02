<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('compra_id')->unsigned();
            $table->bigInteger('produto_id')->unsigned();
            $table->decimal('quantidade',10,2);
            $table->decimal('valor',10,2);

            $table  ->foreign('produto_id')
                    ->references('id')
                    ->on('produtos');

            $table  ->foreign('compra_id')
                    ->references('id')
                    ->on('compras');
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
        Schema::dropIfExists('compra_itens');
    }
}
