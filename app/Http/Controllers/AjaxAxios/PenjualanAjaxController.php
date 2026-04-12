<?php

namespace App\Http\Controllers\AjaxAxios;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanAjaxController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::all();
        return view('ajax_axios.penjualanAjax', compact('penjualan'))->with('title', 'Penjualan (Ajax)');
    }

    public function create()
    {
        return view('ajax_axios.penjualanCreateAjax');
    }

    public function searchBarang(Request $request)
    {
        $kode = $request->kode;
        if (is_numeric($kode)) {
            $kode = 'BRG-' . str_pad($kode, 4, "0", STR_PAD_LEFT);
        }
        $barang = Barang::where('id_barang', $kode)->first();
        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Barang tidak dapat ditemukan'
        ], 404);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $penjualan = new Penjualan();
            $penjualan->total = $request->total;
            $penjualan->save();
            // dd($penjualan);

            $barang = $request->barang;
            foreach ($barang as $b) {
                $detail = new DetailPenjualan();
                $detail->id_penjualan = $penjualan->id_penjualan;
                $detail->id_barang = $b['kode'];
                $detail->jumlah = $b['jumlah'];
                $detail->subtotal = $b['subtotal'];
                $detail->save();
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi gagal disimpan'
            ], 500);
        }
    }

    public function getDetails($id)
    {
        $details = DetailPenjualan::with('barang')->where('id_penjualan', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $details
        ]);
    }
}
