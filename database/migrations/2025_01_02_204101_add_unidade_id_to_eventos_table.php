<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnidadeIdToEventosTable extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            if (!Schema::hasColumn('eventos', 'unidade_id')) {
                $table->unsignedBigInteger('unidade_id')->after('id');
                $table->foreign('unidade_id')
                    ->references('id')
                    ->on('unidades')
                    ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            if (Schema::hasColumn('eventos', 'unidade_id')) {
                $table->dropForeign(['unidade_id']);
                $table->dropColumn('unidade_id');
            }
        });
    }
}
