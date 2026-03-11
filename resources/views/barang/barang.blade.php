@extends('layouts.main.main')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="card-title">Buku</div>
                    {{-- <a href="{{ route('buku.create') }}" class="btn btn-sm btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Buku
                    </a> --}}
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('barang.label') }}" method="POST">
                    @csrf
                    <div class="form-row align-items-center bg-light p-3 rounded mb-4">
                        <div class="form-group">
                            <label>Mulai Kolom X:</label>
                            <input type="number" class="form-control" name="x" value="1" min="1" max="5" required>
                        </div>

                        <div class="form-group">
                            <label>Mulai Kolom Y:</label>
                            <input type="number" class="form-control" name="y" value="1" min="1" max="8" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <button type="submit" class="btn btn-gradient-primary btn-fw">
                                Generate Label
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>                    
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barang as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->nama_barang}}</td>
                                <td>Rp{{ number_format($b->harga, 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="itemQty[{{ $b->idbarang }}]" value="0" min="0" class="form-control">
                                </td>
                            </tr>
                            
                            @empty
                            <tr>
                                <td colspan="6" class="align-middle text-center">No Datas Found!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection