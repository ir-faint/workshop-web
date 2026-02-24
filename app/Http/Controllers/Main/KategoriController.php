<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return view('app.kategori', compact('kategori'));
    }
    public function create()
    {
        return view('app.create.kategori_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['nama_kategori' => 'required|string|max:100']);

        Kategori::create($validated);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $request->idkategori . ',idkategori',
        ]);
        $kategori = Kategori::findOrFail($request->idkategori);

        if ($request->nama_kategori === $kategori->nama_kategori) {
            return back()->with('success', 'Kategori berhasil diubah!');
        }

        $oldPrefix = strtoupper(substr($kategori->nama_kategori, 0, 1) . substr($kategori->nama_kategori, 2, 1));
        $newPrefix = strtoupper(substr($request->nama_kategori, 0, 1) . substr($request->nama_kategori, 2, 1));

        if ($newPrefix === $oldPrefix) {
            $kategori->update($validated);
            return back()->with('success', 'Kategori berhasil diubah!');
        }

        $buku = Buku::where('idkategori', $kategori->idkategori)->get();
        foreach ($buku as $b) {
            $part = explode('-', $b->kode);
            $num = $part[1];
            $newKode = $newPrefix . '-' . $num;
            $b->update(['kode' => $newKode]);
        }

        $kategori->update($validated);
        return back()->with('success', 'Kategori berhasil diubah dan kode buku telah diperbarui!');
    }

    public function destroy(Request $request)
    {
        $kategori = Kategori::findOrFail($request->idkategori);
        $kategori->delete();
        return back()->with('success', 'Kategori dan buku yang terasosiasi berhasil dihapus!');
    }
}
