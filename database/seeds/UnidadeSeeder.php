<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            'titulo' => 'Portaria 01'
        ]);
        DB::table('unidades')->insert([
            'titulo' => 'Portaria 02'
        ]);
    }
}
