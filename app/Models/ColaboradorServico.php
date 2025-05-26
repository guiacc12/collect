<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaboradorServico extends Model
{
    use HasFactory;

    protected $table = 'colaborador_servico';

    protected $fillable = ['colaborador_id', 'servico_id', 'quantidade', 'valor', 'data_producao'];
}
