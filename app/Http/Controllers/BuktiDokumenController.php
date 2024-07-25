<?php

namespace App\Http\Controllers;

use App\Models\AjuanMagang;
use App\Models\BuktiMagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BuktiDokumenController extends Controller
{
    public function index(Request $request)
    {
        $dokumen = $this->ajuanMagang($request->ajuan);
        // dd('');
        $activePage = 'dokumen';

        if (Auth::user()->role_id == '1') {
            return view('mahasiswa.dokumen', compact('dokumen'));
        } elseif (Auth::user()->role_id == '2') {
            return view('cdc.Pengajuan.dokumen', compact('dokumen', 'activePage'));
        } elseif (Auth::user()->role_id == '3') {
            return view('admin.dokumen', compact('dokumen', 'activePage'));
        } else {
            return redirect()->back()->with('error', 'Role tidak dikenali.');
        }
    }

    private function ajuanMagang($ajuan)
    {
        return AjuanMagang::findOrFail($ajuan);
    }

    public function store(Request $request, $id)
    {
        if (Auth::user()->role_id == '1') {
            $request->validate([
                'jawaban' => 'required',
                'nama_file' => 'required|file',
            ]);

            DB::transaction(function () use ($request, $id) {
                $bukti = new BuktiMagang;

                // Simpan file nama_file
                if ($request->hasFile('nama_file')) {
                    $file = $request->file('nama_file');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/buktimagang', $filename);

                    $bukti->nama_file = $filename;
                }

                $bukti->ajuan_id = $id;
                $bukti->jawaban = $request->input('jawaban');
                $bukti->save();
            });

            return redirect()->route('viewsuccess')->with('success', 'Ajuan magang berhasil diajukan!');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
    }

    public function delete(Request $request, $id)
    {
        $bukti = BuktiMagang::findOrFail($id);

        $buktimagangPath = public_path('storage/buktimagang/' . $bukti->nama_file);
        if (file_exists($buktimagangPath)) {
            unlink($buktimagangPath);
        }

        $bukti->delete();

        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
