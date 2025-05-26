<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function colaboradores()
    {
        return $this->belongsToMany(Colaborador::class, 'colaborador_servico')
                    ->withPivot('valor', 'data_producao')
                    ->withTimestamps();
    }
}
