<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('placa');
            $table->string('modelo');
            $table->boolean('tipo');
            $table->string('observacao');
            
            //  2. Create foreign key column
            $table->bigInteger('unidade_id')->unsigned();
            // 3. Create foreign key constraints
            
            $table  ->foreign('unidade_id')
                            ->references('id')
                            ->on('unidades');

            

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
        Schema::dropIfExists('veiculos');
    }
}
