<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AjuanMagang;
use App\Models\Proposal;
use App\Models\Anggota;
use App\Models\Instansi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AjuanMagangController extends Controller
{
    public function index()
    {
        $ajuan = AjuanMagang::all();
        $user = User::all();
        $anggota = Anggota::all();
        $proposal = Proposal::all();
        $dosen = User::where('role_id', 5)->get();
        if (Auth()->user()->role_id == 1) {
            return view('mahasiswa.tambahpengajuan', compact('ajuan', 'user', 'anggota', 'proposal', 'dosen'));
        } else {
            abort(404);
        }
    }

    public function success()
    {
        return view('mahasiswa.successtambahpengajuan');
    }

    public function store(Request $request)
    {
        $anggotaIds = [];
        if ($request->input('jenis_kegiatan') === 'kelompok' && $request->has('nama') && $request->has('nim')) {
            $namaAnggota = $request->input('nama');
            $nimAnggota = $request->input('nim');

            foreach ($namaAnggota as $key => $nama) {
                $anggota = new Anggota();
                $anggota->nama = $nama;
                $anggota->nim = $nimAnggota[$key];
                $anggota->save();
                $anggotaIds[] = $anggota->id;
            }
        }

        $instansi = new Instansi();
        $instansi->nama_instansi = $request->input('nama_instansi');
        $instansi->kategori_instansi_id = $request->input('kategori_instansi_id');
        $instansi->no_telpon = $request->input('no_telpon');
        $instansi->alamat_surat = $request->input('alamat_surat');
        $instansi->alamat_instansi = $request->input('alamat_instansi');
        $instansi->save();

        $proposal = new Proposal();
        if ($request->hasFile('nama_file')) {
            $file = $request->file('nama_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('public/proposal', $filename);
            $proposal->nama_file = 'proposal/' . $filename; // Simpan path lengkap ke database
        } else {
            $proposal->nama_file = null;
        }

        $proposal->judul_proposal = $request->input('judul_proposal');
        $proposal->save();

        $ajuan = new AjuanMagang();
        $ajuan->angkatan = $request->input('angkatan');
        $ajuan->status = 'ajuan diproses';
        $ajuan->surat_pengantar = $request->input('surat_pengantar');
        $ajuan->surat_tugas = $request->input('surat_tugas');
        $ajuan->jenis_ajuan = $request->input('jenis_ajuan');
        $ajuan->bobot_sks = $request->input('bobot_sks');
        $ajuan->instansi_id = $instansi->id;
        $ajuan->semester = $request->input('semester');
        $ajuan->tahun = $request->input('tahun');
        $ajuan->file_nilai = $request->input('file_nilai');
        $ajuan->tanggal_mulai = $request->input('tanggal_mulai');
        $ajuan->tanggal_selesai = $request->input('tanggal_selesai');
        $ajuan->jenis_kegiatan = $request->input('jenis_kegiatan');
        $ajuan->proposal_id = $proposal->id;
        $ajuan->dosen_pembimbing = $request->input('dosen_pembimbing');
        $ajuan->user_id = auth()->user()->id;

        // Convert anggotaIds to the desired format
        $formattedAnggotaIds = array_map(function ($id) {
            return ['id' => $id];
        }, $anggotaIds);

        // Check if formattedAnggotaIds is not empty before assigning
        if (!empty($formattedAnggotaIds)) {
            $ajuan->anggota_id = json_encode($formattedAnggotaIds);
        }

        $ajuan->save();

        return redirect()->route('viewsuccess')->with('success', 'Ajuan magang berhasil diajukan!');
    }
}
