<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ControleAcesso extends Model
{

    // id, unidade_id, tipo, lote_id, veiculo_id, motorista, motivo, observacao, data_entrada, data_saida, created_at, updated_at

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($controleAcesso) {
            $unidadeId = $controleAcesso->unidade_id ?? 0;
            $ultimoNumero = self::where('unidade_id', $unidadeId)
                ->whereNotNull('protocolo')
                ->orderBy('id', 'desc')
                ->value('protocolo');

            $ultimoNumero = $ultimoNumero ? (int) explode('-', $ultimoNumero)[1] : 0;
            $novoNumero = str_pad($ultimoNumero + 1, 4, '0', STR_PAD_LEFT);

            $controleAcesso->protocolo = "{$unidadeId}-{$novoNumero}";
        });
    }

    protected $fillable = [
        "id",
        "tipo",
        "lote_id",
        "unidade_id",
        "veiculo_id",
        "motorista",
        "data_entrada",
        "data_saida",
        "entregador",
        "observacao",
        "retirado_por",
        "motivo"
    ];
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id', 'id');
    }

    public function getDescTipoAttribute()
    {
        if (!isset($this->tipo)) {
            return '';
        }

        $codes = new TableCode();

        try {
            return $codes->getDescricaoById(5, $this->tipo);
        } catch (\Exception $e) {
            return 'Tipo não encontrado'; // Mensagem de fallback
        }
    }

    public function EncomendasNaoEntregues()
    {
        return $this->where('unidade_id', Auth::user()->unidade_id)
        ->whereNull('data_saida')
            ->get(); // Retorna uma coleção de objetos
    }

    public function totalEncomendasEntregues()
    {
        return $this->where('unidade_id', Auth::user()->unidade_id)
            ->whereNotNull('data_saida')
            ->count(); // Retorna um número
    }

    public function EncomendasEntregues()
    {

        return $this->where('unidade_id', Auth::user()->unidade_id, 'data_saida', NULL)->get()->first();
    }

    public function QuantidadesVisitantes()
    {

        return $this->where('unidade_id', Auth::user()->unidade_id, 'hora_de_saida', NULL)->get()->first();
    }

    public function QuantidadesCadVisitantes()
    {

        return $this->where('unidade_id', Auth::user()->unidade_id, 'hora_de_saida', NULL)->get()->first();
    }

    public function visitantesPresentes()
    {
        return $this->where('unidade_id', Auth::user()->unidade_id)
            ->whereNull('hora_de_saida')
            ->get(); // Retorna uma coleção
    }
}
