@extends('layouts.main.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">Create Buku</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"> <a href="{{ route('buku') }}">Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Buku</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">        
        <div class="card">
            <div class="card-body">
                <div class="card-title">Create Buku</div>
                <div class="card-description">Tambah Buku baru</div>
                <form action="{{ route('buku.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="idkategori" class="form-select form-control-lg" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @forelse ($kategori as $k)
                                <option value="{{ $k->idkategori }}">{{ $k->nama_kategori }}</option>
                            @empty
                                <option value="" disabled>No Datas Found!</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" id="judul" name="judul" class="form-control" required maxlength="500">
                    </div>
                    <div class="form-group">
                        <label for="pengarang">Pengarang</label>
                        <input type="text" id="pengarang" name="pengarang" class="form-control" required maxlength="200">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('buku') }}" class="btn btn-gradient-secondary btn-fw">Cancel</a>
                        <button type="submit" class="btn btn-gradient-primary btn-fw">Submit</button>
                    </div>                   
                </form>
            </div>
        </div>
    </div>
</div>
@endsection