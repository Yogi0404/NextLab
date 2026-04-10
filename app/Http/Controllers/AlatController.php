<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Alat::query();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%')
                ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
        }

        // 🎯 FILTER KATEGORI
        if ($request->kategori && $request->kategori != 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        $alats = $query->latest()->get();

        return view('admin.alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alat.create');
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'kode_alat' => 'required|unique:alats',
            'nama_alat' => 'required',
            'kategori' => 'required',
            'total_stok' => 'required|integer',
            'kondisi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'kode_alat' => $request->kode_alat,
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'total_stok' => $request->total_stok,
            'stok_tersedia' => $request->total_stok, // otomatis sama
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ];

        // ✅ HANDLE UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        \App\Models\Alat::create($data);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alat = \App\Models\Alat::findOrFail($id);
        return view('admin.alat.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $alat = \App\Models\Alat::findOrFail($id);

        $request->validate([
            'kode_alat' => 'required|unique:alats,kode_alat,' . $alat->id,
            'nama_alat' => 'required',
            'kategori' => 'required',
            'total_stok' => 'required|integer',
            'kondisi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🔥 HANDLE FOTO
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }

            $fotoPath = $request->file('foto')->store('alat', 'public');
        } else {
            $fotoPath = $alat->foto;
        }

        // 🔥 LOGIC STOK (LEBIH AMAN)
        $selisih = $request->total_stok - $alat->total_stok;
        $stokTersediaBaru = $alat->stok_tersedia + $selisih;

        // biar ga minus
        if ($stokTersediaBaru < 0) {
            $stokTersediaBaru = 0;
        }

        $alat->update([
            'kode_alat' => $request->kode_alat,
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'total_stok' => $request->total_stok,
            'stok_tersedia' => $stokTersediaBaru,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = \App\Models\Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil dihapus!');
    }
}
