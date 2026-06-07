<?php

namespace App\Http\Controllers;

use App\Models\LokasiToko;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class KunjunganTokoController extends Controller
{
    public function index()
    {
        $lokasi_toko = LokasiToko::all();
        return view('kunjungan_toko.index', compact('lokasi_toko'))->with('title', 'Daftar Lokasi Toko');
    }

    public function create()
    {
        return view('kunjungan_toko.create')->with('title', 'Input Titik Awal Toko');
    }

    public function store(Request $request)
    {
        $request->validate([
            'qrcode' => 'required|string|max:8|unique:lokasi_toko,qrcode',
            'nama_toko' => 'required|string|max:50',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric',
        ]);

        LokasiToko::create([
            'qrcode' => $request->qrcode,
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
        ]);

        return redirect()->route('lokasi_toko.index')->with('status', 'Data toko berhasil ditambahkan!');
    }

    public function visit()
    {
        return view('kunjungan_toko.visit')->with('title', 'Kunjungan Toko (Scan QR Code)');
    }

    public function getStoreData(Request $request)
    {
        $qrcode = $request->input('qrcode');
        
        if (!$qrcode) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak ditemukan']);
        }

        $toko = LokasiToko::find($qrcode);

        if ($toko) {
            return response()->json([
                'success' => true,
                'data' => [
                    'qrcode' => $toko->qrcode,
                    'nama_toko' => $toko->nama_toko,
                    'latitude' => $toko->latitude,
                    'longitude' => $toko->longitude,
                    'accuracy' => $toko->accuracy,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan']);
    }

    public function printQrCode($qrcode)
    {
        $toko = LokasiToko::findOrFail($qrcode);
        
        // Generate SVG string using simple-qrcode
        $qrCodeSvg = QrCode::size(120)->generate($toko->qrcode);
        
        $data = [
            'toko' => $toko,
            'qrCodeBase64' => base64_encode($qrCodeSvg),
        ];

        $pdf = Pdf::loadView('kunjungan_toko.label', $data);
        $pdf->setPaper([0, 0, 160, 200], 'portrait');
        return $pdf->stream('qrcode_toko_' . $toko->qrcode . '.pdf');
    }
}
