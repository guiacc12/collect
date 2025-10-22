<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendedor;
use App\Models\User;

class VendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuários com role 'vendor'
        $vendorUsers = User::where('role', 'vendor')->get();

        foreach ($vendorUsers as $user) {
            // Verificar se já existe um vendedor com este email
            $vendedorExistente = Vendedor::where('email', $user->email)->first();
            
            if (!$vendedorExistente) {
                Vendedor::create([
                    'nome' => $user->name,
                    'email' => $user->email,
                    'telefone' => $user->phone ?? null,
                    'whatsapp' => $user->phone ?? null,
                    'comissao' => 5.0, // 5% de comissão padrão
                    'senha' => $user->password,
                    'role' => 'vendor',
                ]);
            }
        }
    }
}