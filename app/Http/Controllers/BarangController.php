<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.barang', compact('barang'))->with('title', 'Data Barang');
    }

    public function label(Request $request)
    {
        $x = (int) $request->input('x');
        $y = (int) $request->input('y');
        $Totqty = $request->input('itemQty');
        $print = [];
        // dd($print);
        // dd($Totqty);
        foreach ($Totqty as $id => $qty) {
            // dd($qty);
            if ($qty > 0) {
                $barang = Barang::find($id);
                // dd($barang);
                if ($barang) {
                    for ($i = 0; $i < $qty; $i++) {
                        $print[] = $barang;
                    }
                }
            }
        }
        if (empty($print)) {
            return back()->withErrors(['message' => 'Masukkan jumlah diatas 0 untuk minimal satu item/barang']);
        }

        $skip = ($y - 1) * 5 + ($x - 1);
        for ($i = 0; $i < $skip; $i++) {
            array_unshift($print, null);
        }

        $pages = array_chunk($print, 40);
        $pdf = Pdf::loadView('barang.label', compact('pages'));
        $paper = [0, 0, 595.266, 467.709];
        $pdf->setPaper($paper, 'potrait');

        return $pdf->stream('label.pdf');
    }
}
