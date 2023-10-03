<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //  1. Drop Lotacao column
            $table->dropColumn(['lotacao']);
            //  2. Create foreign key column
             $table->unsignedBigInteger('unidade_id')->after('id');
            //  3. Create foreign key constraints
            $table  ->foreign('unidade_id')
                    ->references('id')
                    ->on('unidades')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            // 1. Recreate lotacao
            $table->integer('lotacao')->after('role');

            // 2. Drop foreign key constraints
            $table->dropForeign(['unidade_id']);

            // 3. Drop the column
            $table->dropColumn('unidade_id');
        });
    }
}
