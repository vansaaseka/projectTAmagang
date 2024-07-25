<?php

namespace App\Http\Controllers;

use App\Models\AjuanMagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelesaiMagangController extends Controller
{
    public function index()
    {
        $selesaimagang = AjuanMagang::all();

        if (Auth::user()->role_id == '1') {
            $selesaimagang = AjuanMagang::where('user_id', auth()->id())->get();

            $activePage = 'selesaimagang';
            return view('mahasiswa.dataajuan', compact('selesaimagang', 'activePage'));
        } elseif (Auth::user()->role_id == '2') {

            $selesaimagang = AjuanMagang::all();

            $activePage = 'selesaimagang';
            return view('cdc.Pengajuan.dokumen', compact('selesaimagang', 'activePage'));
        } elseif (Auth::user()->role_id == '3') {

            $selesaimagang = AjuanMagang::all();

            $activePage = 'selesaimagang';
            return view('admin.dokumen', compact('selesaimagang', 'activePage'));
        }
    }

    public function update(Request $request, $id)
    {
        $ajuanMagang = AjuanMagang::findOrFail($id);

        if ($request->hasFile('file_nilai')) {
            if ($ajuanMagang->file_nilai) {
                Storage::disk('public')->delete($ajuanMagang->file_nilai);
            }
            $file = $request->file('file_nilai');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('nilaimagang', $filename, 'public');
            $ajuanMagang->file_nilai = $filePath;
        }

        if ($request->hasFile('laporan_akhir')) {
            if ($ajuanMagang->laporan_akhir) {
                Storage::disk('public')->delete($ajuanMagang->laporan_akhir);
            }
            $file = $request->file('laporan_akhir');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporanakhir', $filename, 'public');
            $ajuanMagang->laporan_akhir = $filePath;
        }

        $ajuanMagang->save();

        return redirect()->route('datapengajuan.index')->with('success', 'Data pengajuan berhasil diupdate.');
    }

    public function updateNilai(Request $request, $id)
    {
        $nilaimagang = AjuanMagang::findOrFail($id);

        if ($request->hasFile('file_nilai')) {
            if ($nilaimagang->file_nilai) {
                Storage::disk('public')->delete($nilaimagang->file_nilai);
            }

            $pdfPath = $request->file('file_nilai')->store('nilaimagang', 'public');
            $nilaimagang->file_nilai = $pdfPath;
        }

        $nilaimagang->save();

        return redirect()->route('datapengajuan.index')->with('success', 'Nilai magang berhasil diupdate.');
    }
    public function updateLaporanAkhir(Request $request, $id)
    {

        $nilaimagang = AjuanMagang::findOrFail($id);

        if ($request->hasFile('laporan_akhir')) {
            if ($nilaimagang->laporan_akhir) {
                Storage::disk('public')->delete($nilaimagang->laporan_akhir);
            }

            $pdfPath = $request->file('laporan_akhir')->store('laporan_akhir', 'public');
            $nilaimagang->laporan_akhir = $pdfPath;
        }

        $nilaimagang->save();

        return redirect()->route('datapengajuan.index')->with('success', 'Laporan Akhir magang berhasil diupdate.');
    }

    public function suratSelesai(Request $request, $id)
    {
        $ajuanmagang = AjuanMagang::findOrFail($id);

        if ($request->hasFile('surat_selesai')) {
            if ($ajuanmagang->surat_selesai) {
                Storage::disk('public')->delete($ajuanmagang->surat_selesai);
            }

            $pdfPath = $request->file('surat_selesai')->store('surat_selesai', 'public');

            $ajuanmagang->surat_selesai = $pdfPath;
        }
        $ajuanmagang->status = 'magang selesai';
        $ajuanmagang->save();

        return redirect()->route('datapengajuan.index')->with('success', 'Surat Selesai magang berhasil diupdate.');
    }
}
