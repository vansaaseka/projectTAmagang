<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AjuanMagang;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataAjuanExport;

class CetakDataController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role_id, ['2', '3'])) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $activePage = 'pengajuan';
        $status = $request->input('status');
        $view = '';

        if (Auth::user()->role_id == '2') {
            $query = AjuanMagang::query();
            $view = 'cdc.Pengajuan.cetakdata';
        } elseif (Auth::user()->role_id == '3') {
            $query = AjuanMagang::whereIn('status', ['proses validasi', 'siap download', 'magang selesai']);
            $view = 'admin.cetakdata';
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $dataajuan = $query->with(['users.units', 'instansis', 'dosenPembimbing', 'buktimagangs'])->orderBy('created_at', 'desc')->get();

        return view($view, compact('dataajuan', 'activePage'));
    }


    public function export(Request $request)
    {
        $semester = $request->input('semester');
        $tahun = $request->input('tahun');

        return Excel::download(new DataAjuanExport($semester, $tahun), 'data-ajuan-magangSV.xlsx');
    }
}
