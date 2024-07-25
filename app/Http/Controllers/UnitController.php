<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $prodi = Unit::all();
        $activePage = 'dataprodi';
        return view('cdc.Prodi.tampilprodi', compact('prodi', 'activePage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaprodi' => 'required',
        ]);

        Unit::create([
            'nama_prodi' => $request->namaprodi,
        ]);

        return redirect()->route('dataprodi.index')->with('toast_success', 'Data Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaprodi' => 'required',
        ]);

        $prodi = Unit::findOrFail($id);
        $prodi->update([
            'nama_prodi' => $request->namaprodi,
        ]);

        return redirect()->route('dataprodi.index')->with('toast_success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $prodi = Unit::findOrFail($id);
        $prodi->delete();
        return redirect()->route('dataprodi.index')->with('toast_success', 'Data Berhasil Dihapus');
    }
}
