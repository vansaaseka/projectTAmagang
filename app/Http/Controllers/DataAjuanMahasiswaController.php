<?php

namespace App\Http\Controllers;

use App\Models\AjuanMagang;
use App\Models\Anggota;
use App\Models\Proposal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DataAjuanMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $status = $request->input('status');

        if (Auth::user()->role_id == '1') {
            $query = AjuanMagang::where('user_id', auth()->id());
        } elseif (Auth::user()->role_id == '2') {
            $query = AjuanMagang::query();
            $activePage = 'pengajuan';
        } elseif (Auth::user()->role_id == '3') {
            $query = AjuanMagang::whereIn('status', ['proses validasi', 'siap download', 'magang selesai', 'approve']);
            $activePage = 'pengajuan';
        } elseif (Auth::user()->role_id == '4') {
            $query = AjuanMagang::whereIn('status', ['proses validasi', 'siap download', 'magang selesai', 'approve']);
            $activePage = 'pengajuan';
        } elseif (Auth::user()->role_id == '5') {
            $query = AjuanMagang::where('dosen_pembimbing', Auth::user()->id);
            $activePage = 'pengajuan';
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $dataajuan = $query->orderBy('created_at', 'desc')->get();

        foreach ($dataajuan as $data) {
            $data->formatted_tanggal_mulai = Carbon::parse($data->tanggal_mulai)->translatedFormat('d F Y');
            $data->formatted_tanggal_selesai = Carbon::parse($data->tanggal_selesai)->translatedFormat('d F Y');
        }

        Log::info('Data Ajuan:', $dataajuan->toArray());

        if (Auth::user()->role_id == '5') {
            $anggotas = collect();

            foreach ($dataajuan as $ajuan) {
                if (!empty($ajuan->anggota_id)) {
                    $anggotaIds = json_decode($ajuan->anggota_id, true);
                    foreach ($anggotaIds as $anggotaId) {
                        $anggota = Anggota::find($anggotaId['id']);
                        if ($anggota) {
                            $anggotas->push($anggota);
                        }
                    }
                }
            }

            return view('dosen.datapengajuan', compact('dataajuan', 'activePage', 'anggotas'));
        }

        if (Auth::user()->role_id == '1') {
            return view('mahasiswa.dataajuan', compact('dataajuan'));
        } elseif (Auth::user()->role_id == '2') {
            return view('cdc.Pengajuan.datapengajuan', compact('dataajuan', 'activePage'));
        } elseif (Auth::user()->role_id == '3') {
            return view('admin.datapengajuan', compact('dataajuan', 'activePage'));
        } elseif (Auth::user()->role_id == '4') {
            return view('dekanat.datapengajuan', compact('dataajuan', 'activePage'));
        }
    }

    public function update(Request $request, $id)
    {
        $dataajuan = AjuanMagang::findOrFail($id);

        //update proposal setelah perbaikan
        if (Auth::user()->role_id == '1') {
            $request->validate([
                'nama_file' => 'nullable|file|mimes:pdf|max:4084',
            ]);

            $dataajuan->update(['jenis_ajuan' => 'jenis_perbaikan']);

            if ($request->hasFile('nama_file')) {
                $file = $request->file('nama_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/proposal', $filename);
                $storedFilename = 'proposal/' . $filename;

                if (!empty($dataajuan->proposals->nama_file)) {
                    $oldProposalPath = public_path('storage/' . $dataajuan->proposals->nama_file);
                    if (file_exists($oldProposalPath)) {
                        unlink($oldProposalPath);
                    }
                }

                $dataajuan->proposals()->update(['nama_file' => $storedFilename]);
            }

            return redirect()->back()->with('success', 'Data pengajuan berhasil diubah.');

            //ubah status
        } elseif (Auth::user()->role_id == '2') {
            $request->validate([
                'status' => 'required|array',
                'komentar_status' => 'required|string|max:255',
            ]);

            $status = $request->input('status');
            $komentarStatus = $request->input('komentar_status');

            if (in_array('proses validasi', $status)) {
                $dataajuan->update(['status' => 'proses validasi']);
            } elseif (in_array('perbaikan proposal', $status)) {
                $dataajuan->update(['status' => 'perbaikan proposal']);
            }

            $dataajuan->komentar_status = $komentarStatus;
            $dataajuan->save();

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
        } elseif (Auth::user()->role_id == '3') {
            $request->validate([
                'status' => 'required|array',
            ]);

            $status = $request->input('status');
            $dataajuan->update(['status' => 'siap download']);

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
        } elseif (Auth::user()->role_id == '5') {
            $request->validate([
                'status' => 'required|array',
            ]);

            $status = $request->input('status');

            if (in_array('magang selesai', $status)) {
                $dataajuan->update(['status' => 'magang selesai']);
            }

            $dataajuan->save();

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
        }

        $request->validate([
            'surat_pengantar' => 'nullable|file|mimes:doc,docx,pdf',
            'proposal' => 'nullable|file|mimes:doc,docx,pdf',
        ]);

        // Simpan file surat pengantar
        if ($request->hasFile('surat_pengantar')) {
            $file = $request->file('surat_pengantar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_pengantar', $filename);
            $suratPengantarPath = 'surat_pengantar/' . $filename;
            $dataajuan->update(['surat_pengantar' => $suratPengantarPath]);
        }

        // Simpan file proposal
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/proposal', $filename);
            $proposalPath = 'proposal/' . $filename;
            $dataajuan->update(['proposal' => $proposalPath]);
        }

        // Jika kedua file ada, perbarui status menjadi 'siap download'
        if ($request->hasFile('surat_pengantar') && $request->hasFile('proposal')) {
            $dataajuan->update(['status' => 'siap download']);
        }

        return redirect()->back()->with('success', 'Data pengajuan dan dokumen berhasil diubah.');
    }


    public function approve(Request $request, $id)
    {
        $dataajuan = AjuanMagang::findOrFail($id);

        if (in_array(Auth::user()->role_id, [3, 4])) {
            $request->validate([
                'verified' => 'required',
            ]);

            $dataajuan->update(['verified' => 'approve']);

            if (Auth::user()->role_id == 3) {
                $dataajuan->update(['status' => 'approve']);
            } else if (Auth::user()->role_id == 4) {
                $dataajuan->update(['status' => 'approve']);
            }

            return redirect()->back()->with('success', 'Pengajuan berhasil disetujui.');
        } else if (Auth::user()->role_id == 5) {
            $dataajuan->update(['verified' => 'approve final']);

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
        }

        return redirect()->back()->withErrors(['unauthorized' => 'Anda tidak memiliki izin untuk melakukan tindakan ini.']);
    }

    public function store(Request $request, $id)
    {
        if (Auth::user()->role_id == '3') {
            $request->validate([
                'nama_file' => 'required|file',
                'surat_pengantar' => 'required|file',
                'surat_tugas' => 'required|file|mimes:pdf|max:2048',
            ]);

            DB::transaction(function () use ($request, $id) {
                $proposal = Proposal::findOrFail($id);

                // Simpan file proposal
                if ($request->hasFile('nama_file')) {
                    $file = $request->file('nama_file');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/proposal', $filename);

                    if ($proposal->nama_file) {
                        Storage::delete('public/proposal/' . $proposal->nama_file);
                    }

                    $proposal->nama_file = $filename;
                }

                // Simpan file surat pengantar
                if ($request->hasFile('surat_pengantar')) {
                    $file = $request->file('surat_pengantar');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/surat_pengantar', $filename);
                    $ajuan = AjuanMagang::where('proposal_id', $proposal->id)->firstOrFail();

                    if ($ajuan->surat_pengantar) {
                        Storage::delete('public/surat_pengantar/' . $ajuan->surat_pengantar);
                    }

                    $ajuan->surat_pengantar = $filename;
                    $ajuan->save();
                }

                // Simpan file surat tugas
                if ($request->hasFile('surat_tugas')) {
                    $file = $request->file('surat_tugas');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/surat_tugas', $filename);

                    if ($proposal->ajuan->surat_tugas) {
                        Storage::delete('public/surat_tugas/' . $proposal->ajuan->surat_tugas);
                    }

                    $proposal->ajuan->surat_tugas = $filename;
                    $proposal->ajuan->status = 'magang selesai';
                    $proposal->ajuan->save();
                }

                $proposal->save();
            });

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
    }

    public function delete(Request $request, $id)
    {
        $dataajuan = AjuanMagang::findOrFail($id);

        $proposalPath = public_path('storage/proposal/' . $dataajuan->proposals->nama_file);
        if (file_exists($proposalPath)) {
            unlink($proposalPath);
        }

        $dataajuan->proposals()->delete();
        $dataajuan->delete();

        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus.');
    }

    public function upload(Request $request, $id)
    {
        $dataajuan = AjuanMagang::findOrFail($id);

        switch (Auth::user()->role_id) {
            case '1':
                $request->validate([
                    'nama_file' => 'nullable|file|mimes:pdf|max:4084',
                ]);

                $dataajuan->update(['jenis_ajuan' => 'jenis_perbaikan']);

                if ($request->hasFile('nama_file')) {
                    $file = $request->file('nama_file');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/proposal', $filename);

                    $dataajuan->proposals()->update(['nama_file' => $filename]);
                }

                return redirect()->back()->with('success', 'Data pengajuan berhasil diubah.');

            case '2':
                $request->validate([
                    'status' => 'required|array',
                    'komentar_status' => 'required|string|max:255',
                ]);

                $status = $request->input('status');
                $komentarStatus = $request->input('komentar_status');

                if (in_array('proses validasi', $status)) {
                    $dataajuan->update(['status' => 'proses validasi']);
                } elseif (in_array('perbaikan proposal', $status)) {
                    $dataajuan->update(['status' => 'perbaikan proposal']);
                }

                $dataajuan->komentar_status = $komentarStatus;
                $dataajuan->save();

                return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');

            case '3':
                $request->validate([
                    'surat_pengantar' => 'required|file|mimes:pdf|max:4084',
                    'proposal' => 'required|file|mimes:pdf|max:4084',
                ]);

                if ($request->hasFile('surat_pengantar')) {
                    $file = $request->file('surat_pengantar');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filepath = $file->storeAs('public/surat_pengantar', $filename);
                    $storedFilename = 'surat_pengantar/' . $filename;
                    $dataajuan->update(['surat_pengantar' => $storedFilename]);
                }

                if ($request->hasFile('proposal')) {
                    $file = $request->file('proposal');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filepath = $file->storeAs('public/proposal', $filename);
                    $storedFilename = 'proposal/' . $filename;

                    if ($dataajuan->proposals) {
                        $dataajuan->proposals->update(['nama_file' => $storedFilename]);
                    } else {
                        return redirect()->back()->with('error', 'Proposal not found for the given AjuanMagang.');
                    }
                }

                if ($request->hasFile('surat_pengantar') && $request->hasFile('proposal')) {
                    $dataajuan->update(['status' => 'siap download']);
                }

                return redirect()->back()->with('success', 'Data pengajuan berhasil diubah.');

            case '5':
                $request->validate([
                    'status' => 'required|array',
                ]);

                $status = $request->input('status');

                if (in_array('magang selesai', $status)) {
                    $dataajuan->update(['status' => 'magang selesai']);
                }

                $dataajuan->save();

                return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');

            default:
                $request->validate([
                    'surat_pengantar' => 'nullable|file|mimes:doc,docx,pdf',
                    'proposal' => 'nullable|file|mimes:doc,docx,pdf',
                ]);

                // Simpan file surat pengantar
                if ($request->hasFile('surat_pengantar')) {
                    $suratPengantarPath = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
                    $dataajuan->update(['surat_pengantar' => $suratPengantarPath]);
                }

                // Simpan file proposal
                if ($request->hasFile('proposal')) {
                    $proposalPath = $request->file('proposal')->store('proposal', 'public');
                    $dataajuan->update(['proposal' => $proposalPath]);
                }

                // Jika kedua file ada, perbarui status menjadi 'siap download'
                if ($request->hasFile('surat_pengantar') && $request->hasFile('proposal')) {
                    $dataajuan->update(['status' => 'siap download']);
                }

                return redirect()->back()->with('success', 'Data pengajuan dan dokumen berhasil diubah.');
        }
    }

    public function surattugas(Request $request, $id)
    {
        if (Auth::user()->role_id == '3') {
            $request->validate([
                'surat_tugas' => 'required|file|mimes:pdf|max:2048',
            ]);

            DB::transaction(function () use ($request, $id) {
                $ajuan = AjuanMagang::findOrFail($id);

                // Simpan file surat_tugas
                if ($request->hasFile('surat_tugas')) {
                    $file = $request->file('surat_tugas');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/surat_tugas', $filename);

                    if ($ajuan->surat_tugas) {
                        Storage::delete('public/surat_tugas/' . $ajuan->surat_tugas);
                    }

                    $ajuan->surat_tugas = $filename;
                    $ajuan->save();
                }
            });

            return redirect()->back()->with('success', 'Surat Tugas berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
    }
}
