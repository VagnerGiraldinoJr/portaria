<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteLogsTable extends Migration
{
    public function up()
    {
        Schema::create('lote_logs', function (Blueprint $table) {
            $table->bigIncrements('id'); // Substitui $table->id()
            $table->unsignedBigInteger('lote_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('acao'); // Ex: 'inadimplente', 'regularizado', 'tentativa_reserva_bloqueada'
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lote_logs');
    }
}
