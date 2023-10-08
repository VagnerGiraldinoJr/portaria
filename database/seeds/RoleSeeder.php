<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'slug' => 'administrador',
            'description' => 'Administrador',
        ]);

        DB::table('roles')->insert([
            'name' => 'Operador',
            'slug' => 'Operador',
            'description' => 'Operador',
        ]);
    }
}
