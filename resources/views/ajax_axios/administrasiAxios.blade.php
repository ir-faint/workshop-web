@extends('layouts.main.main')


@section('content')
    
<div class="page-header">
    <h3 class="page-title">Administrasi Indonesia (Axios)</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrasi Indonesia</li>
        </ul>
    </nav>
</div>
<div class="row">

    <div class="col-lg-12 grid-margin stretch-card">        
        <div class="card">
            <div class="card-body">
                <div class="card-title">Administrasi Wilayah Indonesia</div>
                <div class="form-group">
                    <label for="provinsi">Provinsi:</label>
                    <select id="provinsi" class="form-select">
                        <option value="">-- Pilih Provinsi --</option>
                        @forelse ($provinsi as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @empty
                            
                        @endforelse
                        {{-- <option value="11">Aceh</option>
                        <option value="35">Jawa Timur</option>  --}}
                    </select>
                </div>
                <div class="form-group">
                    <label for="kota">Kota:</label>
                    <select id="kota" class="form-select" disabled>
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan:</label>
                    <select id="kecamatan" class="form-select" disabled>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelurahan">Kelurahan:</label>
                    <select id="kelurahan" class="form-select" disabled>
                        <option value="">-- Pilih Kelurahan --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                let idProv = $(this).val();
                // console.log(idProv);
                $('#kota').html('<option value="">-- Pilih Kota --</option>')
                $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>')
                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

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
                        $('#kelurahan').prop('disabled', true);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                } else {
                    $('#kota').prop('disabled', true);
                    $('#kecamatan').prop('disabled', true);
                    $('#kelurahan').prop('disabled', true);
                }
            })

            $('#kota').change(function() {
                let idKota = $(this).val();
                // console.log(idProv);
                $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>')
                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

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
                        $('#kelurahan').prop('disabled', true);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                } else {
                    $('#kecamatan').prop('disabled', true);
                    $('#kelurahan').prop('disabled', true);
                }
            })

            $('#kecamatan').change(function() {
                let idKecamatan = $(this).val();
                // console.log(idProv);
                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

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
                        $('#kelurahan').prop('disabled', false).html(option);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                } else {
                    $('#kelurahan').prop('disabled', true);
                }
            })
        })
    </script>
@endpush
@endsection