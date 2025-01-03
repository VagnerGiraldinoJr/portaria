<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usuário Administrador
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 1, // 1 para Admin
            'unidade_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário Porteiro
        DB::table('users')->insert([
            'name' => 'Porteiro',
            'email' => 'porteiro@admin.com',
            'password' => Hash::make('porteiro123'),
            'role' => 2, // 2 para Porteiro
            'unidade_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
