<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
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
}
