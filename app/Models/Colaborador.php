<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';
    protected $fillable = ['nome', 'telefone'];

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'colaborador_servico')
                    ->withPivot('valor', 'data_producao', 'quantidade')
                    ->withTimestamps();
    }

    public function colaboradorServicos()
    {
        return $this->hasMany(ColaboradorServico::class);
    }
}
