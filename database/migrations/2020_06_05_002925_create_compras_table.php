<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpf_cnpj',20);
            $table->string('nome_razaosocial');


            $table->decimal('valor',10,2);
            $table->decimal('acrescimo',10,2);
            $table->decimal('desconto',10,2);
            $table->decimal('valor_total',10,2);

            $table->date('data_entrada');
            $table->datetime('data_hora')->useCurrent();
            $table->string('cadastrado_por');
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
        Schema::dropIfExists('compras');
    }
}
