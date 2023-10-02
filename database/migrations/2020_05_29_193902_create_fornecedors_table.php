<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('tipo');
            $table->string('cpf_cnpj',20);

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
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedors');
    }
}
