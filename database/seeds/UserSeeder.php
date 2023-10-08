<?php

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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@dominare.seg.br',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('admin'),
            'remember_token' => 'remember_token',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'role' => '2', // 2 = Admin
            'unidade_id' => '1', // Condomínio 01
        ]);

        DB::table('users')->insert([
            'name' => 'portaria',
            'email' => 'portaria@dominare.seg.br',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('portaria'),
            'remember_token' => 'remember_token',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'role' => '0', // Usuário
            'unidade_id' => '2', // Condomínio 02
        ]);
    }
}
// php artisan migrate:fresh --seed
