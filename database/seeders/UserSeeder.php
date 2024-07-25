<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'role_id' => '1',
                'name' => 'mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('12345678'),
                'status' => 1
            ],
            [
                'role_id' => '2',
                'name' => 'timcdc',
                'email' => 'cdc@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('cdc123'),
                'status' => 1
            ],
            [
                'role_id' => '3',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('admin123'),
                'status' => 1
            ],
            [
                'role_id' => '4',
                'name' => 'dekan',
                'email' => 'dekan@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('dekan123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'dosen',
                'email' => 'dosen@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Agus Purbayu, S.Si.,M.Kom',
                'email' => 'bayoe@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Sahirul Alim Tri Bawono, S.Kom., M.Kom.',
                'email' => 'sahirul@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Eko Harry Pratisto, S.T., M.Info.Tech., Ph.D.',
                'email' => 'ekoharry@gmail.com',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Hartatik, S.Si., M.Si.',
                'email' => 'hartatik119@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Rudi Hartono, S.Si., M.Eng.',
                'email' => 'rudi.hartono@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Mohammad Asrie Safi’i S.Si., M.Kom.',
                'email' => 'safiie99@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Abdul Aziz, S.Kom., M.Cs.',
                'email' => 'aaziz@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Fendi Aji Purnomo, S.SI., M.Eng.',
                'email' => 'fendi_aji@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Berliana Kusuma Riasti, S.T., M.Eng.',
                'email' => 'berliana@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Nanang Maulana Yoeseph, S.Si., M.Cs.',
                'email' => 'nanang.my@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Ovide Decroly Wisnu Ardhi, S.T., M.Eng.',
                'email' => 'ovide@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Taufiqurrakhman Nur Hidayat, S.Kom., M.Cs.',
                'email' => 'taufiqurrakhman.nh@staff .uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Yudho Yudhanto, S.Kom., M.Kom.',
                'email' => 'yyudhanto@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Nurul Firdaus, S.Kom., M.Info.Tech.',
                'email' => 'nurul.firdaus@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Fiddin Yusfida A’La, S.T., M.Eng.',
                'email' => 'fiddin@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Masbahah, S.Pd., M.Pd.',
                'email' => 'masbahah@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
            [
                'role_id' => '5',
                'name' => 'Nur Azizul Haqimi, S.Kom., M.Cs.',
                'email' => 'n.azizul.haqimi@staff.uns.ac.id',
                'prodi_id' => 1,
                'password' => Hash::make('dosen123'),
                'status' => 1
            ],
        ];

        DB::table('users')->insert($posts);
    }
}
