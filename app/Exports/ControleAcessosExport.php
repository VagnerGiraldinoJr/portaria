<?php
// app/Exports/ControleAcessosExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ControleAcessosExport implements FromCollection, WithHeadings
{
    protected $controleAcessos;

    public function __construct($controleAcessos)
    {
        $this->controleAcessos = $controleAcessos;
    }

    public function collection()
    {
        return $this->controleAcessos;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Unidade',
            'Tipo',
            'Data de Entrada',
            'Data de Saída',
            'Motorista',
            'Motivo',
            'Observação'
        ];
    }
}
