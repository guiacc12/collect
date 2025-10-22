<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaboradorServico extends Model
{
    use HasFactory;

    protected $table = 'colaborador_servico';

    protected $fillable = ['colaborador_id', 'servico_id', 'quantidade', 'valor', 'data_producao'];

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

    // Accessor para calcular valor_total
    public function getValorTotalAttribute()
    {
        return $this->valor * $this->quantidade;
    }
}
