@extends('layouts.main.main')


@section('content')
    
<div class="page-header">
    <h3 class="page-title">Buku</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku</li>
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
                    <div class="card-title">Buku</div>
                    <a href="{{ route('buku.create') }}" class="btn btn-sm btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Buku
                    </a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Kategori Buku</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->kode}}</td>
                                <td>{{ $b->judul}}</td>
                                <td>{{ $b->pengarang}}</td>
                                <td>{{ $b->kategori->nama_kategori}}</td>
                                <td>
                                    <button type="button" class="btn btn-inverse-warning btn-sm btn-icon" title="Edit Buku" data-bs-toggle="modal" data-bs-target="#updateBukuModal{{ $b->idbuku }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-inverse-danger btn-sm btn-icon" title="Delete Buku" data-bs-toggle="modal" data-bs-target="#destroyBukuModal{{ $b->idbuku }}">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="align-middle text-center">No Datas Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@forelse ($buku as $b)
    <div class="modal fade" id="updateBukuModal{{ $b->idbuku }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formUpdate" action="{{ route('buku.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Edit Buku</h5></div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $b->idbuku }}" name="idbuku">
                        <div class="form-group">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ $b->judul }}" maxlength="500" required>
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror                            
                        </div>
                        <div class="form-group">
                            <label for="judul" class="form-label">Pengarang Buku</label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ $b->pengarang }}" maxlength="200" required>
                            @error('pengarang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-gradient-secondary btn-fw" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-gradient-primary btn-fw" onclick="submitForm(this, 'formUpdate')">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="destroyBukuModal{{ $b->idbuku }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formDelete" action="{{ route('buku.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Delete Buku</h5></div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $b->idbuku }}" name="idbuku">
                        <p>Are you sure you want to delete this Buku?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-gradient-secondary btn-fw" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-gradient-primary btn-fw" onclick="submitForm(this, 'formDelete')">Yes</button>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
@empty
    
@endforelse
@endsection