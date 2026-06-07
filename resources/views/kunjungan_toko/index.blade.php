@extends('layouts.main.main')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Lokasi Toko</h4>
                    <a href="{{ route('lokasi_toko.create') }}" class="btn btn-sm btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Toko
                    </a>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>QR Code</th>
                                <th>Nama Toko</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Accuracy</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lokasi_toko as $toko)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $toko->qrcode }}</td>
                                <td>{{ $toko->nama_toko }}</td>
                                <td>{{ $toko->latitude }}</td>
                                <td>{{ $toko->longitude }}</td>
                                <td>{{ $toko->accuracy }}m</td>
                                <td>
                                    <a href="{{ route('lokasi_toko.qrcode', $toko->qrcode) }}" target="_blank" class="btn btn-sm btn-info btn-icon-text">
                                        <i class="mdi mdi-printer btn-icon-prepend"></i> Cetak QR Code
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="align-middle text-center">Belum ada data toko!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
