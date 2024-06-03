<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteIdToVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            if (!Schema::hasColumn('visitantes', 'lote_id')) {
                Schema::table('visitantes', function (Blueprint $table) {
                    $table->unsignedBigInteger('lote_id')->nullable();
                    $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
                });
            }
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitantes', function (Blueprint $table) {
            $table->dropForeign(['lote_id']);
            $table->dropColumn('lote_id');
        });
    }
}