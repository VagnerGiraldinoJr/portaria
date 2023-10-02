<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP function IF EXISTS f_desc_table_codes;
                        CREATE FUNCTION f_desc_table_codes(p_pai INT, p_valor INT) RETURNS varchar(30) CHARSET latin1 DETERMINISTIC
                        BEGIN
                            DECLARE v_desc VARCHAR(30) ;
                            SET v_desc:= "";
                            SELECT descricao INTO v_desc FROM table_codes WHERE pai = p_pai AND valor = p_valor AND item <> 0;
                        RETURN v_desc;
                        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP function IF EXISTS f_desc_table_codes;');
    }
}
