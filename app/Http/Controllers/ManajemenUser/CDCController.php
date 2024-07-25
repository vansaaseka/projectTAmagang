<?php

namespace App\Http\Controllers\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\AjuanMagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CDCController extends Controller
{
    public function index()
    {
        $timcdc = User::where('role_id', 2)->get();

        $activePage = 'manajemenuser';
        return view('cdc.ManajemenUser.tampilCDC', compact('activePage', 'timcdc'));
    }

    public function store(Request $request)
    {
        $akun = new User;
        $akun->name = $request->input('name');
        $akun->email = $request->input('email');
        $akun->nip = $request->input('nip');
        $akun->no_wa = $request->input('no_wa');
        $akun->role_id = 2;
        $akun->status = 1;
        $akun->password = Hash::make($request->password);

        $akun->save();

        return redirect()->route('datatimcdc.index')->with('toast_success', 'Data Berhasil Tersimpan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'no_wa' => 'required',
            'password' => 'nullable',
        ]);

        $akun = User::findOrFail($id);
        $akun->name = $request->input('name');
        $akun->email = $request->input('email');
        $akun->nip = $request->input('nip');
        $akun->no_wa = $request->input('no_wa');

        if ($request->filled('password')) {
            $akun->password = Hash::make($request->password);
        }

        $akun->save();

        return redirect()->route('datatimcdc.index')->with('toast_success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('datatimcdc.index')->with('toast_success', 'Data Berhasil Dihapus');
    }

    public function ubahstatus($id)
    {
        $akun = User::findOrFail($id);
        $akun->status = $akun->status == 1 ? 0 : 1;
        $akun->save();

        return redirect()->route('datatimcdc.index')->with('toast_success', 'Status Berhasil Diubah');
    }
}
