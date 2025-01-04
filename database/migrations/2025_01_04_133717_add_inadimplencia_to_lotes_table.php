<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInadimplenciaToLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->boolean('inadimplente')->default(false);
            $table->timestamp('inadimplente_em')->nullable();
            $table->unsignedBigInteger('inadimplente_por')->nullable();
            $table->timestamp('regularizado_em')->nullable();
            $table->unsignedBigInteger('regularizado_por')->nullable();

            $table->foreign('inadimplente_por')->references('id')->on('users')->onDelete('set null');
            $table->foreign('regularizado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn(['inadimplente', 'inadimplente_em', 'inadimplente_por', 'regularizado_em', 'regularizado_por']);
        });
    }
}
