<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpf_cnpj',20);
            $table->date('data_nascimento');

            $table->string('nome_razaosocial');
            $table->string('cep',10);
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('numero');
            $table->string('localidade');
            $table->string('uf');
            $table->string('complemento');


            $table->string('email');
            $table->string('telefone');
            $table->string('celular');
            $table->string('recado')->nullable()->default(null);
            $table->text('observacoes')->nullable()->default(null);
            $table->softDeletes('deleted_at', 0);

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
        Schema::dropIfExists('clientes');
    }
}
