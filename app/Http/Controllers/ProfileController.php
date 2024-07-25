<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function profileDosen()
    {
        $users = User::where('id', Auth::id())->first();
        $activePage = 'profile';
        if (empty(auth()->user()->no_wa)) {
            session()->flash('warning', 'Lengkapi Data Profil, untuk bisa melihat pengajuan pengajuan!!');
        }

        return view('dosen.editprofile', compact('users', 'activePage'));
    }

    public function insertProfile(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::findOrFail($userid);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userid,
            'nip' => 'required|string|max:20|unique:users,nip,' . $userid,
            'no_wa' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->no_wa = $request->no_wa;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        session()->flash('success', 'Data Berhasil Tersimpan');
        return redirect()->route('dashboard'); 
    }
}
