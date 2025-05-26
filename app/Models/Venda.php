<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendedor_id', 'produto_nome', 'comprador_nome', 'quantidade',
        'valor_venda', 'status', 'cpf_cnpj', 'cep', 'rua', 'numero',
        'complemento', 'bairro', 'cidade', 'estado'
    ];

    protected $casts = [
        'status' => 'boolean', // Garante que o status seja tratado como booleano
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }
}
