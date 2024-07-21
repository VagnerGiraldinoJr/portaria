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
            $table->bigInteger('lote_id')->unsigned();
            $table->string('nome_completo');
            $table->string('rg', 15);
            $table->string('celular', 11)->nullable();
            $table->integer('tipo');
            //  2. Create foreign key column
            // 3. Create foreign key constraints            
            $table->foreign('lote_id')
                ->references('id')
                ->on('lotes');

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
        Schema::dropIfExists('pessoas');
    }
}
