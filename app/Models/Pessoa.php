<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        "nome_completo",
        "celular",
        "rg",
        "tipo",
        "lote_id",
        "desc_tipo"

    ];

    protected $appends = ['desc_tipo'];

    public function getDescTipoAttribute()
    {
        $codes = new TableCode();
        return (isset($this->tipo) && $this->tipo != NULL) ? $codes->getDescricaoById(4, $this->tipo) : '';
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    public function getTipoRegistroAttribute()
    {
        switch ($this->tipo) {
            case 1:
                return 'MORADOR(A)';
            case 2:
                return 'SÍNDICO(A)';
            case 3:
                return 'FUNCIONÁRIO TERCEIRIZADO';
            case 4:
                return 'VISITANTES';
            case 5:
                return 'IMOBILIÁRIA';
            case 6:
                return 'INQUILINO(A)';
            default:
                return 'DESCONHECIDO';
        }
    }

    public function getReferenciaMesAttribute()
    {
        // Verifica se o lote está inadimplente
        if ($this->lote && $this->lote->inadimplente && $this->lote->inadimplente_em) {
            // Retorna a data formatada como MM/YYYY
            return Carbon::parse($this->lote->inadimplente_em)->format('m/Y');
        }

        // Caso contrário, retorna nulo ou outra mensagem padrão
        return '----';
    }
}
