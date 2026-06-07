<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>QR Code Label - {{ $toko->nama_toko }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 5px;
            text-align: center;
            box-sizing: border-box;
        }
        .container {
            margin: 0;
        }
        .title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .qrcode {
            margin: 5px 0;
        }
        .code {
            font-size: 10px;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">{{ $toko->nama_toko }}</div>
        <div class="qrcode">
            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" width="100" height="100" />
        </div>
        <div class="code">{{ $toko->qrcode }}</div>
    </div>
</body>
</html>
