<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pai')->default(0);
            $table->integer('item')->default(0);
            $table->string('valor');
            $table->integer('flag')->default(0);
            
            $table->string('descricao');
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
        Schema::dropIfExists('table_codes');
    }
}
