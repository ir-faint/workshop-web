<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Price Labels</title>
    <style>
        @page {
            size: 21cm 16.5cm;
            margin: 0; 
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            /* box-sizing: border-box; */
        }
        .page-sheet {
            position: relative;
            width: 21cm;
            height: 16.5cm;
            /* page-break-after: always; */
            font-size: 0;
        }
        .label-box {
            position: absolute;
            width: 3.8cm;  
            height: 1.8cm; 
            text-align: center;
            box-sizing: border-box;
            padding-top: 0.1cm;
            font-size: 10pt;
            border: 1px solid red;
        }
        .item-name {
            font-size: 7pt;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            margin-bottom: 1px;
        }
        .item-barcode {
            margin-top: 1px;
            margin-bottom: 1px;
        }
        .item-id {
            font-size: 6pt;
            margin-bottom: 1px;
        }
        .item-price {
            font-size: 8pt;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>

    @php
        // variable
        $marginLeft = 0.4;  // Margin from left edge of paper
        $marginTop  = 0.3;  // Margin from top edge of paper
        $labelW     = 3.8;  // Label width
        $labelH     = 1.8;  // Label height
        $gapX       = 0.3;  // Horizontal gap between stickers
        $gapY       = 0.2;  // Vertical gap between stickers
        $generator  = new Picqer\Barcode\BarcodeGeneratorPNG();
    @endphp

    @foreach ($pages as $page)
        <div class="page-sheet" style="{{ !$loop->last ? 'page-break-after: always;' : '' }}">
            @foreach ($page as $index => $item)
                @if ($item)
                    @php
                        $row = floor($index / 5); 
                        $col = $index % 5;

                        $leftPos = $marginLeft + ($col * ($labelW + $gapX));
                        $topPos  = $marginTop + ($row * ($labelH + $gapY));
                    @endphp
                    
                    <div class="label-box" style="left: {{ $leftPos }}cm; top: {{ $topPos }}cm;">
                        {{-- <div class="item-name">{{ substr($item->nama_barang, 0, 18) }}</div> --}}
                        <div class="item-barcode">
                            <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode((string) $item->id_barang, $generator::TYPE_CODE_128, 1, 30)) }}" style="height: 24px;" alt="barcode">
                        </div>
                        <div class="item-id">{{ $item->id_barang }}</div>
                        <div class="item-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach

</body>
</html>