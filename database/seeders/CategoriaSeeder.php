<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desativa a verificação de chaves estrangeiras para evitar erros ao truncar a tabela
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpa a tabela antes de popular para evitar duplicatas
        // DB::table('categorias')->truncate();

        DB::table('categorias')->insert([
            [
                'id' => 4,
                'nome' => 'CHAISE',
                'slug' => 'chaise',
                'foto' => 'uploads/media_67e6c9e493087-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:10:33',
                'updated_at' => '2025-03-28 13:10:12',
            ],
            [
                'id' => 5,
                'nome' => 'POLTRONAS / NAMORADEIRAS / SOFÁS',
                'slug' => 'poltronas-namoradeiras-sofas',
                'foto' => 'uploads/media_67e6e0a27f0a8-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:17:49',
                'updated_at' => '2025-03-28 14:47:14',
            ],
            [
                'id' => 6,
                'nome' => 'BANQUETAS / BISTRO',
                'slug' => 'banquetas-bistro',
                'foto' => 'uploads/media_67e6e0c28f83e-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:22:16',
                'updated_at' => '2025-03-28 14:47:46',
            ],
            [
                'id' => 7,
                'nome' => 'BALANÇOS',
                'slug' => 'balancos',
                'foto' => 'uploads/media_67e6ec72038ca-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:26:08',
                'updated_at' => '2025-03-28 15:37:38',
            ],
            [
                'id' => 8,
                'nome' => 'ESPREGUIÇADEIRAS',
                'slug' => 'espreguicadeiras',
                'foto' => 'uploads/media_67e6e0d9e247c-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:28:00',
                'updated_at' => '2025-03-28 14:48:09',
            ],
            [
                'id' => 9,
                'nome' => 'CADEIRAS E CONJUNTO DE MESA',
                'slug' => 'cadeiras-e-conjunto-de-mesa',
                'foto' => 'uploads/media_67e6e0e4e6803-collect-28-03-25-.svg',
                'status' => 1,
                'created_at' => '2025-03-28 11:30:25',
                'updated_at' => '2025-03-28 14:48:20',
            ],
        ]);

        // Reativa a verificação de chaves estrangeiras
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
