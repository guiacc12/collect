<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Guilherme Carrera',
                'username' => 'gacc1',
                'email' => 'guuicarrera12@hotmail.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('gui120696')
            ],

            [
                'name' => 'Vendedor V',
                'username' => 'vendor',
                'email' => 'vendedor@hotmail.com',
                'role' => 'vendor',
                'status' => 'active',
                'password' => bcrypt('123456')
            ],

            [
                'name' => 'User V',
                'username' => 'user',
                'email' => 'user@hotmail.com',
                'role' => 'user',
                'status' => 'active',
                'password' => bcrypt('123456')
            ]
        ]);
    }
}
