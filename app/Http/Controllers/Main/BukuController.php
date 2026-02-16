<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('app.buku', compact('buku'));
    }
    public function create()
    {
        $kategori = Kategori::all();
        return view('app.create.buku_create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'pengarang' => 'required|string|max:200',
            'idkategori' => 'required|exists:kategori,idkategori'
        ]);

        $kategori = Kategori::findOrFail($request->idkategori);
        $prefix = strtoupper(substr($kategori->nama_kategori, 0, 1) . substr($kategori->nama_kategori, 2, 1));
        $latestRecord = Buku::where('kode', 'like', $prefix . '-%')->orderBy('idbuku', 'desc')->first();
        var_dump($latestRecord);
        if ($latestRecord) {
            $latestNum = (int) substr($latestRecord->kode, 3);
            $latestNum = $latestNum + 1;
        } else {
            $latestNum = 1;
        }
        var_dump($latestNum);
        $kode = $prefix . '-' . sprintf("%02d", $latestNum);
        $validated['kode'] = $kode;
        Buku::create($validated);
        return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan! Kode buku:' . $kode);
    }
}
