<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'id' => '1',
                'name' => 'Mahasiswa',
            ],
            [
                'id' => '2',
                'name' => 'TimCDC',
            ],
            [
                'id' => '3',
                'name' => 'Admin',
            ],
            [
                'id' => '4',
                'name' => 'Dekan',
            ],
            [
                'id' => '5',
                'name' => 'Dosen',
            ],
        ];

        DB::table('roles')->insert($posts);
    }
}
