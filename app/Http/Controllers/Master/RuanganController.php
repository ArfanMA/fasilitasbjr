<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('master.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('master.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan gambar jika ada
        $fotoPath = $request->hasFile('foto') 
            ? $request->file('foto')->store('ruangan', 'public') 
            : null;

        Ruangan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('master.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
{
    $ruangan = Ruangan::findOrFail($id);
   // dd(get_class($ruangan)); // Debugging tipe data
    return view('master.ruangan.edit', compact('ruangan'));
}

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $ruangan = Ruangan::findOrFail($id);

        $ruangan->nama = $request->nama;
        $ruangan->deskripsi = $request->deskripsi;

        // Jika ada foto baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('foto')) {
            if ($ruangan->foto) {
                Storage::disk('public')->delete($ruangan->foto);
            }
            $ruangan->foto = $request->file('foto')->store('ruangan', 'public');
        }

        $ruangan->save();

        return redirect()->route('master.ruangan.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($ruangan->foto) {
            Storage::disk('public')->delete($ruangan->foto);
        }

        $ruangan->delete();

        return redirect()->route('master.ruangan.index')->with('success', 'Data berhasil dihapus!');
    }
}
