<?php

namespace App\Http\Controllers;

use App\Models\AjuanMagang;
use App\Models\Instansi;
use App\Models\KategoriInstansi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activePage = 'dashboard';

        $totalProgramStudi = Unit::count();
        $totalInstansi = Instansi::count();
        $totalPengajuan = AjuanMagang::count();
        $jenisKegiatan = AjuanMagang::selectRaw('jenis_kegiatan, count(*) as total')
            ->groupBy('jenis_kegiatan')
            ->pluck('total', 'jenis_kegiatan')
            ->toArray();

        $kategoriInstansiData = KategoriInstansi::withCount('instansis')->get();

        $kategoriInstansi = $kategoriInstansiData->mapWithKeys(function ($item) {
            return [$item->nama_kategori => $item->instansis_count];
        });

        $data = compact('activePage', 'totalProgramStudi', 'totalInstansi', 'totalPengajuan', 'jenisKegiatan', 'kategoriInstansi');

        if (Auth::user()->role_id == '1') {
            $prodi = Auth::user()->prodi_id;
            $user = User::with('units')->where('prodi_id', $prodi)->first();
            return view('mahasiswa.dashboard', compact('user'))->with($data);
        } elseif (Auth::user()->role_id == '2') {
            return view('cdc.dashboard')->with($data);
        } elseif (Auth::user()->role_id == '3') {
            return view('admin.dashboard')->with($data);
        } elseif (Auth::user()->role_id == '4') {
            return view('dekanat.dashboard')->with($data);
        } elseif (Auth::user()->role_id == '5') {
            return view('dosen.dashboard')->with($data);
        }
    }
}
