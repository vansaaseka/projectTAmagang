<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'nama_prodi' => 'D3 Teknik Informatika',
            ],
            [
                'nama_prodi' => 'D3 Teknik Kimia',
            ],
            [
                'nama_prodi' => 'D3 Teknik Mesin',
            ],
            [
                'nama_prodi' => 'D3 Teknik Sipil',
            ],
            [
                'nama_prodi' => 'PSDKU D3 Teknik Informatika',
            ],
            [
                'nama_prodi' => 'D3 Farmasi',
            ],
            [
                'nama_prodi' => 'D3 Kebidanan',
            ],
            [
                'nama_prodi' => 'D4 Kebidanan',
            ],
            [
                'nama_prodi' => 'D4 Keselamatan dan Kesehatan Kerja',
            ],
            [
                'nama_prodi' => 'D3 Budidaya Ternak',
            ],
            [
                'nama_prodi' => 'D3 Agribisnis',
            ],
            [
                'nama_prodi' => 'D3 Teknologi Hasil Pertanian',
            ],
            [
                'nama_prodi' => 'PSDKU D3 Teknologi Hasil Pertanian',
            ],
            [
                'nama_prodi' => 'D3 Manajemen Bisnis',
            ],
            [
                'nama_prodi' => 'D3 Manajemen Pemasaran',
            ],

            [
                'nama_prodi' => 'D3 Manajemen Perdagangan',
            ],

            [
                'nama_prodi' => 'D3 Perpajakan',
            ],

            [
                'nama_prodi' => 'D3 Keuangan dan Perbankan',
            ],

            [
                'nama_prodi' => 'D3 Akuntansi',
            ],

            [
                'nama_prodi' => 'PSDKU D3 Akuntansi',
            ],

            [
                'nama_prodi' => 'D3 Bahasa Inggris',
            ],
            [
                'nama_prodi' => 'D3 Bahasa Mandarin',
            ],
            [
                'nama_prodi' => 'D3 Desain Komunikasi Visual',
            ],
            [
                'nama_prodi' => 'D3 Komunikasi Terapan',
            ],
            [
                'nama_prodi' => 'D3 Usaha Perjalanan Wisata',
            ],
            [
                'nama_prodi' => 'D3 Manajemen Administrasi',
            ],
            [
                'nama_prodi' => 'D3 Perpustakaan',
            ],
            [
                'nama_prodi' => 'D4 Studi Demografi dan Pencatatan Sipil',
            ],
        ];

        DB::table('units')->insert($posts);
    }
}
