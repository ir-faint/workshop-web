@extends('layouts.main.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-account-plus"></i>
        </span> Tambah Customer 1 (Blob)
    </h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('customer.store1') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <select id="provinsi" name="provinsi" class="form-select" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinsi as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <select id="kota" name="kota" class="form-select" disabled required>
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" class="form-select" disabled required>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kodepos_kelurahan">Kodepos - Kelurahan</label>
                        <select id="kodepos_kelurahan" name="kodepos_kelurahan" class="form-select" disabled required>
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <label>Foto</label>
                        <div class="d-flex align-items-center">
                            <div id="results" class="me-3" style="width: 240px; height: 180px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Hasil Foto</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#cameraModal">Ambil Foto</button>
                        </div>
                        <input type="hidden" name="foto_blob" id="foto_blob" required>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2 mt-3">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ambil Foto -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cameraModalLabel">Modal Ambil Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-6 text-center">
                  <h6>Video</h6>
                  <div id="my_camera" style="margin: 0 auto; width: 320px; height: 240px; border: 1px solid #ccc;"></div>
                  <button type="button" class="btn btn-sm btn-secondary mt-2">Pilihan kamera</button>
              </div>
              <div class="col-md-6 text-center">
                  <h6>Snapshot</h6>
                  <div id="my_result" style="margin: 0 auto; width: 320px; height: 240px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
                      <span class="text-muted">Belum ada foto</span>
                  </div>
                  <button type="button" class="btn btn-sm btn-info mt-2" onClick="take_snapshot()">Ambil Foto</button>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="save_photo()">Simpan Foto</button>
      </div>
    </div>
  </div>
</div>
@endsection


@push('script')
<!-- Load Webcam.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<!-- Load Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Konfigurasi Webcam
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    // Ketika modal dibuka, aktifkan kamera
    $('#cameraModal').on('shown.bs.modal', function () {
        Webcam.attach('#my_camera');
    });

    // Ketika modal ditutup, matikan kamera untuk menghemat resource
    $('#cameraModal').on('hidden.bs.modal', function () {
        Webcam.reset();
    });

    var dataUri = '';

    function take_snapshot() {
        // Ambil gambar dan tampilkan di my_result
        Webcam.snap(function(data_uri) {
            dataUri = data_uri;
            $('#my_result').html('<img src="'+data_uri+'"/>');
        });
    }

    function save_photo() {
        if(dataUri) {
            $('#results').html('<img src="'+dataUri+'" style="width: 240px; height: 180px;"/>');
            $('#foto_blob').val(dataUri);
        } else {
            Swal.fire('Oops', 'Silakan ambil foto terlebih dahulu!', 'warning');
        }
    }

    $(document).ready(function() {
        $('#provinsi').change(function() {
            let idProv = $(this).val();
            $('#kota').html('<option value="">-- Pilih Kota --</option>')
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>')
            $('#kodepos_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

            if (idProv !== '') {
                axios.post('{{ route('administrasi.axios.getKota') }}', {
                    _token: "{{ csrf_token() }}",
                    province_id: idProv
                })
                .then(function(response) {                        
                    let option = '<option value="">-- Pilih Kota --</option>'
                    $.each(response.data.data, function(index, kota) {
                        option += `<option value="${kota.id}">${kota.name}</option>`;
                    });
                    $('#kota').prop('disabled', false).html(option);
                    $('#kecamatan').prop('disabled', true);
                    $('#kodepos_kelurahan').prop('disabled', true);
                })
                .catch(function (error) { console.log(error); })
            } else {
                $('#kota').prop('disabled', true);
                $('#kecamatan').prop('disabled', true);
                $('#kodepos_kelurahan').prop('disabled', true);
            }
        })

        $('#kota').change(function() {
            let idKota = $(this).val();
            console.log(idKota);
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>')
            $('#kodepos_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

            if (idKota !== '') {
                axios.post('{{ route('administrasi.axios.getKecamatan') }}', {
                    _token: "{{ csrf_token() }}",
                    regency_id: idKota
                })
                .then(function(response) {                        
                    let option = '<option value="">-- Pilih Kecamatan --</option>'
                    $.each(response.data.data, function(index, kecamatan) {
                        option += `<option value="${kecamatan.id}">${kecamatan.name}</option>`;
                    });
                    $('#kecamatan').prop('disabled', false).html(option);
                    $('#kodepos_kelurahan').prop('disabled', true);
                })
                .catch(function (error) { console.log(error); })
            } else {
                $('#kecamatan').prop('disabled', true);
                $('#kodepos_kelurahan').prop('disabled', true);
            }
        })

        $('#kecamatan').change(function() {
            let idKecamatan = $(this).val();
            $('#kodepos_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

            if (idKecamatan !== '') {
                axios.post('{{ route('administrasi.axios.getKelurahan') }}', {
                    _token: "{{ csrf_token() }}",
                    district_id: idKecamatan
                })
                .then(function(response) {                        
                    let option = '<option value="">-- Pilih Kelurahan --</option>'
                    $.each(response.data.data, function(index, kelurahan) {
                        option += `<option value="${kelurahan.id}">${kelurahan.name}</option>`;
                    });
                    $('#kodepos_kelurahan').prop('disabled', false).html(option);
                })
                .catch(function (error) { console.log(error); })
            } else {
                $('#kodepos_kelurahan').prop('disabled', true);
            }
        })
    });
</script>
@endpush

