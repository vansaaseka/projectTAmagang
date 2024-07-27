<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
           [
            'namatemplate' => 'STKMM Individu',
            'template' => 'STKMM Individu.docx',
           ],
           [
            'namatemplate' => 'STKMM Kelompok',
            'template' => 'STKMM Kelompok.docx',
           ],
           [
            'namatemplate' => 'Surat Pengantar Individu',
            'template' => 'Surat Pengantar Individu.docx',
           ],
           [
            'namatemplate' => 'Surat Pengantar Kelompok',
            'template' => 'Surat Pengantar Kelompok.docx',
           ],
        ];

        DB::table('template')->insert($posts);
    }
}
