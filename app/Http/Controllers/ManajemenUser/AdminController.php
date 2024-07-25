<?php

namespace App\Http\Controllers\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\AjuanMagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('role_id', 3)->get();
        $activePage = 'manajemenuser';
        return view('cdc.ManajemenUser.tampilAdmin', compact('activePage', 'admin'));
    }

    public function store(Request $request)
    {
        $akun = new User;
        $akun->name = $request->input('name');
        $akun->email = $request->input('email');
        $akun->nip = $request->input('nip');
        $akun->no_wa = $request->input('no_wa');
        $akun->role_id = 3;
        $akun->status = 1;
        $akun->password = Hash::make($request->password);

        $akun->save();

        return redirect()->route('dataadmin.index')->with('toast_success', 'Data Berhasil Tersimpan');
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

        return redirect()->route('dataadmin.index')->with('toast_success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('dataadmin.index')->with('toast_success', 'Data Berhasil Dihapus');
    }

    public function ubahstatus($id)
    {
        $akun = User::findOrFail($id);
        $akun->status = $akun->status == 1 ? 0 : 1;
        $akun->save();

        return redirect()->route('dataadmin.index')->with('toast_success', 'Status Berhasil Diubah');
    }

    public function settings()
    {
        $users = Auth::user();
        $activePage = 'settings';

        if (Auth::user()->role_id == 1) {
            return view('mahasiswa.layouts.settings', compact('users', 'activePage'));
        } elseif (Auth::user()->role_id == 2) {
            return view('Cdc.layouts.settings', compact('users', 'activePage'));
        } elseif (Auth::user()->role_id == 3) {
            return view('admin.layouts.settings', compact('users', 'activePage'));
        } elseif (Auth::user()->role_id == 4) {
            return view('dekanat.layouts.settings', compact('users', 'activePage'));
        } elseif (Auth::user()->role_id == 5) {
            return view('dosen.layouts.settings', compact('users', 'activePage'));
        }

        return redirect('dashboard')->with('error', 'Role tidak dikenali.');
    }

    public function settingsUpdate(Request $request)
    {
        $user = User::all()->find(Auth::user()->id);
        $requestData = $request->all();

        // Validasi data sesuai dengan role pengguna
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_wa' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // Sesuaikan validasi untuk NIP atau NIM berdasarkan role
        if ($user->role_id == 1) {
            $validationRules['nim'] = 'required|string|max:255|unique:users,nim,' . $user->id;
        } else {
            $validationRules['nip'] = 'required|string|max:255|unique:users,nip,' . $user->id;
        }

        // Validasi data jika diperlukan
        $validatedData = $request->validate($validationRules);

        // Update data pengguna berdasarkan role
        if ($user->role_id == 1) {
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'nim' => $validatedData['nim'],
                'no_wa' => $validatedData['no_wa'],
                'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
            ]);
        } else {
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'nip' => $validatedData['nip'],
                'no_wa' => $validatedData['no_wa'],
                'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
