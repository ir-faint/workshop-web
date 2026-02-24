<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

// use function Illuminate\Support\now;

class PdfController extends Controller
{
    public function pdfPotrait()
    {
        $data = [
            'title' => 'Contoh Potrait',
            'date' => date('D, F, Y'),
            'sub_title' => 'Teks'
        ];

        $pdf = Pdf::loadView('pdf.potrait', $data);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('contoh-potrait.pdf');
    }

    public function pdfLandscape()
    {
        $data = [
            'title' => 'Contoh Landscape',
            'date' => date('D, F, Y'),
            'sub_title' => 'Teks'
        ];

        $pdf = Pdf::loadView('pdf.landscape', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('contoh-landscape.pdf');
    }
}
