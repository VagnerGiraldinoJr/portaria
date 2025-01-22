<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lote extends Model
{
    protected $fillable = [
        "unidade_id",
        "descricao",
        "inadimplente",
        "inadimplente_em",
        "inadimplente_por",
        "regularizado_em",
        "regularizado_por"
    ];

    protected $casts = [
        'inadimplente_em' => 'datetime',
        'regularizado_em' => 'datetime',
    ];

    //  Um lote pode ter muitos moradores pessoas
    public function pessoas()
    {
        return $this->hasMany(Pessoa::class, 'lote_id');
    }
    // Um Lote pode ter muitas Reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'lote_id');
    }

    // Um Lote pertence a uma Unidade
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    // Usuário que marcou como inadimplente
    public function inadimplentePor()
    {
        return $this->belongsTo(User::class, 'inadimplente_por');
    }

    // Usuário que regularizou
    public function regularizadoPor()
    {
        return $this->belongsTo(User::class, 'regularizado_por');
    }

    // Marcar como inadimplente
    public function marcarInadimplente()
    {
        $this->inadimplente = true;
        $this->inadimplente_em = now();
        $this->inadimplente_por = Auth::id();
        $this->save();
    }

    // Regularizar o lote
    public function regularizar()
    {
        $this->inadimplente = false;
        $this->regularizado_em = now();
        $this->regularizado_por = Auth::id();
        $this->save();
    }

    // Verificar se está inadimplente
    public function estaInadimplente()
    {
        return $this->inadimplente;
    }

    // Acessor para formatar a data de inadimplência
    public function getInadimplenteEmFormatadoAttribute()
    {
        return $this->inadimplente_em ? \Carbon\Carbon::parse($this->inadimplente_em)->format('d/m/Y H:i') : 'N/A';
    }

    // Acessor para formatar a data de regularização
    public function getRegularizadoEmFormatadoAttribute()
    {
        return $this->regularizado_em ? \Carbon\Carbon::parse($this->regularizado_em)->format('d/m/Y H:i') : 'N/A';
    }
}
