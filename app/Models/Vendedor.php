<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'whatsapp',
        'telefone',
        'email',
        'senha',
        'role',
        'comissao',
    ];

    protected $hidden = [
        'senha',
    ];

    /**
     * Calcula a comissão do vendedor para um determinado mês
     */
    public function comissaoDoMes($ano = null, $mes = null)
    {
        $ano = $ano ?: date('Y');
        $mes = $mes ?: date('m');

        $vendas = Venda::where('vendedor_id', $this->id)
            ->where('status', true) // Apenas vendas confirmadas
            ->whereYear('created_at', $ano)
            ->whereMonth('created_at', $mes)
            ->sum('valor_venda');

        return ($vendas * $this->comissao) / 100;
    }

    /**
     * Relacionamento com vendas
     */
    public function vendas()
    {
        return $this->hasMany(Venda::class, 'vendedor_id');
    }
}
