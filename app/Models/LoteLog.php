<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LoteLog extends Model
{
    protected $fillable = ['lote_id', 'user_id', 'acao'];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function marcarInadimplente()
    {
        $this->inadimplente = true;
        $this->inadimplente_em = now();
        $this->inadimplente_por = Auth::id();
        $this->save();

        LoteLog::create([
            'lote_id' => $this->id,
            'user_id' => Auth::id(),
            'acao' => 'inadimplente'
        ]);
    }

    public function regularizar()
    {
        $this->inadimplente = false;
        $this->regularizado_em = now();
        $this->regularizado_por = Auth::id();
        $this->save();

        LoteLog::create([
            'lote_id' => $this->id,
            'user_id' => Auth::id(),
            'acao' => 'regularizado'
        ]);
    }
}
