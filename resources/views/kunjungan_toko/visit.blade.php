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
            <i class="mdi mdi-map-marker-distance"></i>
        </span> Titik Kunjungan (Scan)
    </h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Arahkan Kamera ke QR Code Toko</h4>
                
                <!-- Scanner Container -->
                <div id="reader"></div>

                <!-- Result Card -->
                <div class="card bg-light mt-4 text-start" id="result-card">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="mdi mdi-store"></i> Data Toko (Dari DB)</h5>
                        <p class="mb-1"><strong>QR Code:</strong> <span id="store-qrcode"></span></p>
                        <p class="mb-1"><strong>Nama Toko:</strong> <span id="store-nama"></span></p>
                        <p class="mb-1"><strong>Koordinat:</strong> <span id="store-lat"></span>, <span id="store-lng"></span></p>
                        <p class="mb-3"><strong>Akurasi GPS Toko:</strong> <span id="store-acc"></span> meter</p>

                        <hr>
                        
                        <div id="sales-section" style="display: none;">
                            <h5 class="card-title text-primary"><i class="mdi mdi-account-tie"></i> Data Posisi Sales</h5>
                            <button class="btn btn-sm btn-info mb-3" id="btnAmbilLokasi">Ambil Lokasi</button>
                            
                            <div id="sales-data" style="display: none;">
                                <p class="mb-1"><strong>Koordinat Sales:</strong> <span id="sales-lat"></span>, <span id="sales-lng"></span></p>
                                <p class="mb-1"><strong>Akurasi GPS Sales:</strong> <span id="sales-acc"></span> meter</p>
                                
                                <div class="mt-3 p-3 rounded" id="validation-result-box">
                                    <h5 class="mb-2">Hasil Validasi: <span id="validation-status" class="badge"></span></h5>
                                    <p class="mb-1 text-sm text-muted">Jarak Aktual: <span id="jarak-aktual"></span> meter</p>
                                    <p class="mb-1 text-sm text-muted">Threshold Efektif (Base 250m + Akurasi): <span id="threshold-efektif"></span> meter</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button class="btn btn-sm btn-gradient-primary" onclick="restartScanner()">Scan Ulang QR Code</button>
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
    let storeData = null;

    // Haversine formula from Lampiran 2
    function haversine(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Earth radius in meters
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // High accuracy position from Lampiran 1
    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
        return new Promise((resolve, reject) => {
            let bestResult = null;
            const startTime = Date.now();

            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const acc = position.coords.accuracy;
                    if (!bestResult || acc < bestResult.coords.accuracy) {
                        bestResult = position;
                    }
                    if (acc <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }
                    if (Date.now() - startTime >= maxWait) {
                        navigator.geolocation.clearWatch(watchId);
                        if (bestResult) resolve(bestResult);
                        else reject(new Error("Timeout, tidak dapat posisi"));
                    }
                },
                (error) => reject(error),
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
            );
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.clear().then(() => {
            // Fetch Store Data
            axios.post('{{ route('kunjungan_toko.scan.detail') }}', {
                _token: '{{ csrf_token() }}',
                qrcode: decodedText
            })
            .then(function (response) {
                if (response.data.success) {
                    storeData = response.data.data;
                    
                    $('#store-qrcode').text(storeData.qrcode);
                    $('#store-nama').text(storeData.nama_toko);
                    $('#store-lat').text(storeData.latitude);
                    $('#store-lng').text(storeData.longitude);
                    $('#store-acc').text(storeData.accuracy);
                    
                    $('#result-card').show();
                    $('#sales-section').show();
                    $('#sales-data').hide();
                } else {
                    Swal.fire('Oops!', response.data.message, 'error');
                }
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data toko.', 'error');
            });

        }).catch(error => {
            console.error("Failed to clear scanner. ", error);
        });
    }

    function onScanFailure(error) {
        // Handle scan failure silently
    }

    function startScanner() {
        $('#result-card').hide();
        $('#sales-section').hide();
        storeData = null;
        
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            false);
            
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function restartScanner() {
        startScanner();
    }

    // Ambil Lokasi Sales
    document.getElementById('btnAmbilLokasi').addEventListener('click', async function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mencari lokasi...';
        btn.disabled = true;

        try {
            const pos = await getAccuratePosition(50);
            
            const salesLat = pos.coords.latitude;
            const salesLng = pos.coords.longitude;
            const salesAcc = pos.coords.accuracy;

            $('#sales-lat').text(salesLat);
            $('#sales-lng').text(salesLng);
            $('#sales-acc').text(Math.round(salesAcc));
            
            // Validation Calculation
            const baseThreshold = 250; // Requested threshold
            const storeAcc = parseFloat(storeData.accuracy);
            
            const jarakAktual = haversine(parseFloat(storeData.latitude), parseFloat(storeData.longitude), salesLat, salesLng);
            const thresholdEfektif = baseThreshold + storeAcc + salesAcc;

            $('#jarak-aktual').text(Math.round(jarakAktual));
            $('#threshold-efektif').text(Math.round(thresholdEfektif));

            const statusBadge = $('#validation-status');
            const box = $('#validation-result-box');
            
            if (jarakAktual <= thresholdEfektif) {
                statusBadge.text('DITERIMA').removeClass('badge-danger').addClass('badge-success');
                box.css('border', '2px solid green').css('background-color', '#e8f5e9');
                Swal.fire('Valid', 'Kunjungan Diterima!', 'success');
            } else {
                statusBadge.text('DITOLAK').removeClass('badge-success').addClass('badge-danger');
                box.css('border', '2px solid red').css('background-color', '#ffebee');
                Swal.fire('Invalid', 'Kunjungan Ditolak. Jarak terlalu jauh.', 'error');
            }

            $('#sales-data').show();

        } catch (error) {
            Swal.fire('Gagal!', error.message || 'Tidak dapat mengambil lokasi GPS.', 'error');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });

    $(document).ready(function() {
        startScanner();
    });
</script>
@endpush
