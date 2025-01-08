<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProtocoloToControleAcessosTable extends Migration
{
    public function up()
    {
        Schema::table('controle_acessos', function (Blueprint $table) {
            $table->string('protocolo', 10)->nullable()->after('unidade_id');
        });
    }

    public function down()
    {
        Schema::table('controle_acessos', function (Blueprint $table) {
            $table->dropColumn('protocolo');
        });
    }
}
