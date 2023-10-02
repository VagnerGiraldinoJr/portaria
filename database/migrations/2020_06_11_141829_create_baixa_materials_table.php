<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaixaMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baixa_materials', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('produto_id')->unsigned();
            $table->decimal('quantidade',10,2);
            $table->text('motivo');
            $table->string('cadastrado_por',100);
            $table->date('data_cadastro');
            $table  ->foreign('produto_id')
                    ->references('id')
                    ->on('produtos');
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
        Schema::dropIfExists('baixa_materials');
    }
}
