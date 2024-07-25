<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Kategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'nama_kategori' => 'Perusahaan Multinasional/Internasional',
            ],
            [
                'nama_kategori' => 'Perusahaan Nasional',
            ],
            [
                'nama_kategori' => 'Perusahaan Lokal (PT Lokal, CV, Agensi, Startup, dll)',
            ],
            [
                'nama_kategori' => 'Instansi Pemerintahan (OPD, Kementrian, dll)',
            ],
            [
                'nama_kategori' => 'BUMN (Bank, Pegadaian, PLN, dll)',
            ],
            [
                'nama_kategori' => 'BUMD (RSUD, BPR Daerah, dll)',
            ],
        ];

        DB::table('kategori_instansis')->insert($posts);
    }
}
