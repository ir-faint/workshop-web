@extends('layouts.main.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-map-marker-plus"></i>
        </span> Input Titik Awal Toko
    </h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('lokasi_toko.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="qrcode">QR Code (Max 8 Char)</label>
                        <input type="text" class="form-control" id="qrcode" name="qrcode" placeholder="Contoh: TK-001" required maxlength="8">
                    </div>
                    <div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <input type="text" class="form-control" id="nama_toko" name="nama_toko" placeholder="Nama Toko" required>
                    </div>
                    
                    <h5 class="mt-4 mb-3">Koordinat Lokasi</h5>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="accuracy">Accuracy (meters)</label>
                        <input type="text" class="form-control" id="accuracy" name="accuracy" readonly required>
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-info me-2" id="btnGeoloc">
                            <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi (Geoloc)
                        </button>
                        <button type="submit" class="btn btn-gradient-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // JS Function from Lampiran 1
    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
        return new Promise((resolve, reject) => {
            let bestResult = null;
            const startTime = Date.now();

            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const acc = position.coords.accuracy;

                    // Simpan hasil terbaik sejauh ini
                    if (!bestResult || acc < bestResult.coords.accuracy) {
                        bestResult = position;
                    }

                    // Kalau sudah cukup akurat, berhenti
                    if (acc <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }

                    // Kalau timeout, pakai hasil terbaik yang ada
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

    document.getElementById('btnGeoloc').addEventListener('click', async function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mencari lokasi...';
        btn.disabled = true;

        try {
            // Target akurasi 50 meter
            const pos = await getAccuratePosition(50);
            
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            document.getElementById('accuracy').value = pos.coords.accuracy;
            
            Swal.fire('Berhasil!', `Lokasi didapatkan dengan akurasi ${Math.round(pos.coords.accuracy)} meter.`, 'success');
        } catch (error) {
            Swal.fire('Gagal!', error.message || 'Tidak dapat mengambil lokasi GPS.', 'error');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
</script>
@endpush
