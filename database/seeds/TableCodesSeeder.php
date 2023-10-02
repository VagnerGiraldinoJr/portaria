<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        // VEICULOS CODES
        DB::table('table_codes')->insert([
            'pai' => '2',
            'item' => '0',
            'valor' => 'TIPO VEÍCULO',
            'descricao' => 'TIPO VEÍCULO',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '2',
            'item' => '1',
            'valor' => 1,
            'descricao' => 'VEÍCULO MORADOR',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '2',
            'item' => '2',
            'valor' => 2,
            'descricao' => 'VEÍCULO VISITANTE',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '2',
            'item' => '3',
            'valor' => 3,
            'descricao' => 'VEÍCULOS SERVIÇOS',
        ]);
        
        DB::table('table_codes')->insert([
            'pai' => '2',
            'item' => '4',
            'valor' => 4,
            'descricao' => 'OUTROS VEÍCULOS',
        ]);    

        // PESSOAS CODES
        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '0',
            'valor' => 'TIPO PESSOA',
            'descricao' => 'TIPO PESSOA',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '1',
            'valor' => 1,
            'descricao' => 'MORADOR(A)',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '2',
            'valor' => 2,
            'descricao' => 'SINDICO(A)',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '3',
            'valor' => 3,
            'descricao' => 'FUNCIONÁRIO TERCEIRIZADO',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '4',
            'valor' => 4,
            'descricao' => 'VISITATNES',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '4',
            'item' => '5',
            'valor' => 5,
            'descricao' => 'IMOBILIARIA',
        ]);

        // ENTRADA CODES
        DB::table('table_codes')->insert([
            'pai' => '5',
            'item' => '0',
            'valor' => 'TIPO ENTRADA',
            'descricao' => 'TIPO ENTRADA',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '5',
            'item' => '1',
            'valor' => 1,
            'descricao' => 'PESSOA',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '5',
            'item' => '2',
            'valor' => 2,
            'descricao' => 'VEICULO',
        ]);

        // RECEBIMENTO CODES
        DB::table('table_codes')->insert([
            'pai' => '9',
            'item' => '0',
            'valor' => 'STATUS DO RECEBIMENTO',
            'descricao' => 'STATUS DO RECEBIMENTO',
        ]);

        DB::table('table_codes')->insert([
            'pai' => '9',
            'item' => '1',
            'valor' => 1,
            'descricao' => 'RECEPCIONADO PORTARIA',
        ]);
        
        DB::table('table_codes')->insert([
            'pai' => '9',
            'item' => '2',
            'valor' => 2,
            'descricao' => 'ENTREGUE P/ MORADOR',
        ]);
        
    }
}
