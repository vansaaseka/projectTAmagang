<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AjuanMagang;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CetakDataController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role_id, ['2', '3'])) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $activePage = 'pengajuan';
        $status = $request->input('status');
        $semester = $request->input('semester');
        $tahun = $request->input('tahun');
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

        if (!empty($semester)) {
            $query->where('semester', $semester);
        }

        if (!empty($tahun)) {
            $query->where('tahun', $tahun);
        }

        $dataajuan = $query->with(['users.units', 'instansis', 'dosenPembimbing', 'buktimagangs'])->orderBy('created_at', 'desc')->get();

        return view($view, compact('dataajuan', 'activePage', 'semester', 'tahun'));
    }

    public function export(Request $request)
    {
        $semester = $request->input('semester');
        $tahun = $request->input('tahun');

        // Query data with filtering if parameters are present
        $query = AjuanMagang::query()
            ->with(['users', 'instansis', 'dosenPembimbing'])
            ->select('id', 'semester', 'tahun', 'user_id', 'instansi_id', 'jenis_kegiatan', 'dosen_pembimbing');

        if ($semester) {
            $query->where('semester', $semester);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $data = $query->get();

        return Excel::download(new class($data) implements FromCollection, WithHeadings
        {
            use Exportable;

            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data->map(function ($item) {
                    return [
                        'No' => $item->id, // This will be the No column
                        'Tahun Ajaran' => ($item->semester === 'ganjil' ? 'Ganjil' : 'Genap') . '/' . $item->tahun,
                        'Nama Mahasiswa' => $item->users->name,
                        'Prodi' => $item->users->units ? $item->users->units->nama_prodi : 'Prodi Tidak Ditemukan',
                        'NIM' => $item->users->nim,
                        'Dosen Pembimbing' => $item->dosenPembimbing ? $item->dosenPembimbing->name : 'Dosen Tidak Ditemukan',
                        'Jenis Kegiatan' => $item->jenis_kegiatan === 'individu' ? 'Individu' : 'Kelompok',
                        'Instansi' => $item->instansis ? $item->instansis->nama_instansi : 'Instansi Tidak Ditemukan',
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'No',
                    'Tahun Ajaran',
                    'Nama Mahasiswa',
                    'Prodi',
                    'NIM',
                    'Dosen Pembimbing',
                    'Jenis Kegiatan',
                    'Instansi',
                ];
            }
        }, 'data-ajuan-magang.xlsx');
    }



}
