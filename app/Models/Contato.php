<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'lote_id');
  
    }
}
