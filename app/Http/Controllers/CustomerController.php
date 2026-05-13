<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    public function create1()
    {
        $provinsi = Provinsi::all();
        return view('customer.create1', compact('provinsi'));
    }

    public function store1(Request $request)
    {
        $request->validate([            
            'nama' => 'required|string|max:255',
            'foto_blob' => 'required', // Since it's required in the assignment to take a photo
        ]);

        $fotoBlob = null;
        if ($request->foto_blob) {
            $image_parts = explode(";base64,", $request->foto_blob);
            if (count($image_parts) >= 2) {
                // Konversi base64 ke binary, lalu encode ke hex format PostgreSQL (\x...)
                // Ini mencegah PDO menganggapnya sebagai string UTF-8 biasa.
                $binary_data = base64_decode($image_parts[1]);
                $fotoBlob = '\x' . bin2hex($binary_data);
            }
        }
        DB::beginTransaction();
        try {
            Customer::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'provinsi' => Provinsi::find($request->provinsi)->name ?? null,
                'kota' => Kota::find($request->kota)->name ?? null,
                'kecamatan' => Kecamatan::find($request->kecamatan)->name ?? null,
                'kodepos_kelurahan' => Kelurahan::find($request->kodepos_kelurahan)->name ?? null,
                'foto_blob' => $fotoBlob, // True binary data
            ]);
            DB::commit();
            return redirect()->route('customer.index')->with('status', 'Customer berhasil ditambahkan dengan foto (Blob)!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('customer.index')->with('error', 'Customer gagal ditambahkan!');
        }

    }

    public function create2()
    {
        $provinsi = Provinsi::all();
        return view('customer.create2', compact('provinsi'));
    }

    public function store2(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto_blob' => 'required', 
        ]);

        $fotoPath = null;
        if ($request->foto_blob) {
            $image_parts = explode(";base64,", $request->foto_blob);
            if (count($image_parts) >= 2) {
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'customer_' . time() . '_' . Str::random(10) . '.' . $image_type;
                
                // Simpan menggunakan disk 'public' agar bisa diakses dari web browser
                Storage::disk('public')->put('customers/' . $fileName, $image_base64);
                $fotoPath = 'customers/' . $fileName;
            }
        }

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => Provinsi::find($request->provinsi)->name ?? null,
            'kota' => Kota::find($request->kota)->name ?? null,
            'kecamatan' => Kecamatan::find($request->kecamatan)->name ?? null,
            'kodepos_kelurahan' => Kelurahan::find($request->kodepos_kelurahan)->name ?? null,
            'foto_path' => $fotoPath,
        ]);

        return redirect()->route('customer.index')->with('status', 'Customer berhasil ditambahkan dengan foto (File)!');
    }
}
