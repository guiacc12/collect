<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            [
                'id' => 10,
                'banner' => 'uploads/media_67e21f66b02d4-collect-25-03-25-.svg',
                'titulo' => 'Banner1',
                'descricao' => null,
                'starting_price' => null,
                'slug' => 'banner1',
                'promocao' => null,
                'status' => 1,
                'created_at' => '2025-03-25 00:13:42',
                'updated_at' => '2025-04-15 19:22:55',
            ],
            [
                'id' => 11,
                'banner' => 'uploads/media_67e21ff72091b7-collect-25-03-25-.svg',
                'titulo' => 'Banner2',
                'descricao' => null,
                'starting_price' => null,
                'slug' => 'banner2',
                'promocao' => null,
                'status' => 1,
                'created_at' => '2025-03-25 00:13:54',
                'updated_at' => '2025-03-27 19:11:41',
            ],
            [
                'id' => 12,
                'banner' => 'uploads/media_67e21ff7c8aa60-collect-25-03-25-.svg',
                'titulo' => 'Banner3',
                'descricao' => null,
                'starting_price' => null,
                'slug' => 'banner3',
                'promocao' => null,
                'status' => 1,
                'created_at' => '2025-03-25 00:14:04',
                'updated_at' => '2025-03-25 00:14:04',
            ],
        ]);
    }
}
