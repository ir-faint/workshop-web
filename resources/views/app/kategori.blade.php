@extends('layouts.main.main')


@section('content')
    
<div class="page-header">
    <h3 class="page-title">Kategori</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12"> 
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="col-lg-12 grid-margin stretch-card">        
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="card-title">Kategori</div>
                    <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Kategori
                    </a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Nama Kategori</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->nama_kategori }}</td>
                                <td>
                                    <button type="button" class="btn btn-inverse-warning btn-sm btn-icon" title="Edit Kategori" data-bs-toggle="modal" data-bs-target="#updateKategoriModal{{ $k->idkategori }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-inverse-danger btn-sm btn-icon" title="Delete Kategori" data-bs-toggle="modal" data-bs-target="#destroyKategoriModal{{ $k->idkategori }}">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="align-middle text-center">No Datas Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@forelse ($kategori as $k)
    <div class="modal fade" id="updateKategoriModal{{ $k->idkategori }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kategori.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Edit Kategori</h5></div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $k->idkategori }}" name="idkategori">
                        <div class="form-group">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $k->nama_kategori }}" maxlength="100" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror                            
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-gradient-secondary btn-fw" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-gradient-primary btn-fw">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="destroyKategoriModal{{ $k->idkategori }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kategori.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Delete Kategori</h5></div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $k->idkategori }}" name="idkategori">
                        <h6>Apakah Anda yakin untuk menghapus data kategori?</h6>
                        <p>Penghapusan data kategori akan menghapus pula data buku yang memiliki kategori terkait.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-gradient-secondary btn-fw" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-gradient-primary btn-fw">Yes</button>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
@empty
    
@endforelse
@endsection