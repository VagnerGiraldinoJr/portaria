<?php

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
        // $this->call(UserFactory::class);
        //  $this->call(UnidadeSeeder::class);
        //  $this->call(TableCodesSeeder::class);
        //  $this->call(UserSeeder::class);
        // $this->call(RoleSeeder::class);


    }
}

/*
        Rodar primeiro as seeder:
        //  $this->call(UnidadeSeeder::class);
        //  $this->call(TableCodesSeeder::class);
        //  $this->call(UserSeeder::class);
        Depois :
        php artisan db:seed --class=RoleSeeder;
        