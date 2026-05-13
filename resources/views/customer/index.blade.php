@extends('layouts.main.main')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
    div.dataTables_length select {
        width: 75px !important;
        padding-right: 30px !important;
        background-position: right 0.5rem center !important;
    }
    .table-responsive {
        padding-top: 5px;
    }
    </style>
@endpush

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-account-group"></i>
        </span> Data Customer
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Customer</h4>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="customerTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Provinsi</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $index => $customer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($customer->foto_path)
                                        <img src="{{ Storage::url($customer->foto_path) }}" alt="Foto" style="width: 50px; height: 50px; border-radius: 0;">
                                    @elseif($customer->foto_blob)
                                        <img src="data:image/jpeg;base64,{{ base64_encode(is_resource($customer->foto_blob) ? stream_get_contents($customer->foto_blob) : $customer->foto_blob) }}" alt="Foto" style="width: 50px; height: 50px; border-radius: 0;">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>{{ $customer->nama }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td>{{ $customer->provinsi }}</td>
                                <td>{{ $customer->kota }}</td>
                                <td>{{ $customer->kecamatan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable();
    });
</script>
@endpush
