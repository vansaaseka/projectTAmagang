<?php

namespace App\Http\Controllers;

use App\Models\AjuanMagang;
use App\Models\BuktiMagang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DataBuktiController extends Controller
{
    public function bukti()
    {
        if (Auth::user()->role_id == '2') {
            $databukti = AjuanMagang::with('buktiMagangs')->get();
            $activePage = 'dokumen';
            return view('cdc.pengajuan.dokumen', compact('databukti', 'activePage'));
        } elseif (Auth::user()->role_id == '3') {
            $databukti = AjuanMagang::with('buktiMagangs')->get();
            $activePage = 'dokumen';
            return view('admin.dokumen', compact('databukti', 'activePage'));
        }
    }

    public function store(Request $request, $id)
    {
        if (in_array(Auth::user()->role_id, [2, 3])) {
            $request->validate([
                'surat_tugas' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'buktimagang' => 'required|file|mimes:pdf,doc,docx|max:2048'
            ]);

            DB::transaction(function () use ($request, $id) {
                $ajuan = AjuanMagang::findOrFail($id);

                if ($request->hasFile('surat_tugas')) {
                    if ($ajuan->surat_tugas) {
                        Storage::delete('public/surat_tugas/' . $ajuan->surat_tugas);
                    }

                    $file = $request->file('surat_tugas');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/surat_tugas', $filename);

                    $ajuan->surat_tugas = $filename;
                }

                if ($request->hasFile('buktimagang')) {
                    if ($ajuan->buktimagang) {
                        Storage::delete('public/buktimagang/' . $ajuan->buktimagang);
                    }

                    $file = $request->file('buktimagang');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/buktimagang', $filename);

                    $ajuan->buktimagang = $filename;
                }

                $ajuan->save();
            });

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
    }
}
