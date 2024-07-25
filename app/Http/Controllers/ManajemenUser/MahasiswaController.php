<?php

namespace App\Http\Controllers\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\AjuanMagang;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role_id', 1)->get();
        $prodi = Unit::all();

        $activePage = 'manajemenuser';
        return view('cdc.ManajemenUser.tampilMahasiswa', compact('activePage', 'mahasiswa', 'prodi'));
    }

    public function store(Request $request)
    {
        $akun = new User;
        $akun->name = $request->input('name');
        $akun->email = $request->input('email');
        $akun->nim = $request->input('nim');
        $akun->no_wa = $request->input('no_wa');
        $akun->role_id = 1;
        $akun->status = 1;
        $akun->prodi_id = $request->input('prodi_id');
        $akun->password = Hash::make($request->password);

        $akun->save();

        return redirect()->route('datamahasiswa.index')->with('toast_success', 'Data Berhasil Tersimpan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'nim' => 'required',
            'no_wa' => 'required',
            'prodi_id' => 'required',
            'password' => 'nullable|min:8',
        ]);

        $akun = User::findOrFail($id);
        $akun->name = $request->input('name');
        $akun->email = $request->input('email');
        $akun->nim = $request->input('nim');
        $akun->no_wa = $request->input('no_wa');
        $akun->prodi_id = $request->input('prodi_id');

        if ($request->filled('password')) {
            $akun->password = Hash::make($request->password);
        }

        $akun->save();

        return redirect()->route('datamahasiswa.index')->with('toast_success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('datamahasiswa.index')->with('toast_success', 'Data Berhasil Dihapus');
    }

    public function ubahstatus($id)
    {
        $akun = User::findOrFail($id);
        $akun->status = $akun->status == 1 ? 0 : 1;
        $akun->save();

        return redirect()->route('datamahasiswa.index')->with('toast_success', 'Status Berhasil Diubah');
    }
}
