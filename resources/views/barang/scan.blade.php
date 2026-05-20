@extends('layouts.main.main')

@push('style')
    <style>
        #reader {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
        }
        #result-card {
            display: none;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-barcode-scan"></i>
        </span> Scan Barcode Barang
    </h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Arahkan Kamera ke Barcode/QRCode</h4>
                
                <!-- Scanner Container -->
                <div id="reader"></div>

                <!-- Result Card -->
                <div class="card bg-light mt-4 text-start" id="result-card">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="mdi mdi-check-circle"></i> Scan Berhasil!</h5>
                        <hr>
                        <p class="mb-2"><strong>ID Barang:</strong> <span id="res-id"></span></p>
                        <p class="mb-2"><strong>Nama Barang:</strong> <span id="res-nama"></span></p>
                        <p class="mb-0"><strong>Harga:</strong> <span id="res-harga" class="text-primary font-weight-bold"></span></p>
                        <div class="mt-3 text-center">
                            <button class="btn btn-sm btn-gradient-primary" onclick="restartScanner()">Scan Lagi</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let html5QrcodeScanner;

    function playBeep() {
        // Menggunakan Web Audio API untuk membunyikan 'beep' pendek
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // 880 Hz
        
        gainNode.gain.setValueAtTime(1, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.1); // Beep 0.1 detik

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        oscillator.start();
        oscillator.stop(audioCtx.currentTime + 0.1);
    }

    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.clear().then(() => {
            playBeep();
            
            axios.post('{{ route('barang.scan.detail') }}', {
                _token: '{{ csrf_token() }}',
                id_barang: decodedText
            })
            .then(function (response) {
                if (response.data.success) {
                    let barang = response.data.data;
                    
                    // 5. Tampilkan data ke UI
                    $('#res-id').text(barang.id_barang);
                    $('#res-nama').text(barang.nama_barang);
                    
                    // Format Harga ke Rupiah
                    let formatHarga = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(barang.harga);
                    $('#res-harga').text(formatHarga);
                    
                    // Munculkan Result Card
                    $('#result-card').show();
                } else {
                    Swal.fire('Oops!', response.data.message, 'error');
                }
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data barang.', 'error');
            });

        }).catch(error => {
            console.error("Failed to clear html5QrcodeScanner. ", error);
        });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
    }

    function startScanner() {
        $('#result-card').hide();
        
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { 
                fps: 10, 
                qrbox: {width: 250, height: 150}, 
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA, Html5QrcodeScanType.SCAN_TYPE_FILE],
                formatsToSupport: [ Html5QrcodeSupportedFormats.CODE_128 ] // Optimasi khusus untuk CODE 128
            },
            /* verbose= */ false);
            
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function restartScanner() {
        startScanner();
    }

    // Mulai otomatis saat halaman diload
    $(document).ready(function() {
        startScanner();
    });
</script>
@endpush
