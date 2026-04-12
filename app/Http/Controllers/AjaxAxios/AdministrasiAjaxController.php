<?php

namespace App\Http\Controllers\AjaxAxios;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class AdministrasiAjaxController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        return view('ajax_axios.administrasiAjax', compact('provinsi'))->with('title', 'Administrasi Indonesia (Ajax)');
    }

    public function getKota(Request $request)
    {
        $kota = Kota::where('province_id', $request->province_id)->get();
        // dd($request->province_id);
        // echo ($request->province_id);
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $kota
        ]);
    }

    public function getKecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where('regency_id', $request->regency_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $kecamatan
        ]);
    }

    public function getKelurahan(Request $request)
    {
        $kelurahan = Kelurahan::where('district_id', $request->district_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $kelurahan
        ]);
    }
}
