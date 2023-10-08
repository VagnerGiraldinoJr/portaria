<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = ["placa","modelo","tipo","observacao","unidade_id"];
}
