<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Rodar seeders específicos:

        // $this->call(UnidadeSeeder::class);
        // $this->call(TableCodesSeeder::class);

        $this->call(UserSeeder::class);

        // $this->call(RoleSeeder::class);
    }
}
