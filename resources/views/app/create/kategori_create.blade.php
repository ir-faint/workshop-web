@extends('layouts.main.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">Create Kategori</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Kategori</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Create Kategori</div>
                <div class="card-description">Tambah kategori baru</div>
                <form id="formKategori" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" required autofocus maxlength="100">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('kategori') }}" class="btn btn-gradient-secondary btn-fw">Cancel</a>
                        <button class="btn btn-gradient-primary btn-fw" onclick="submitForm(this, 'formKategori')">Submit</button>
                    </div>                   
                </form>
            </div>
        </div>
    </div>
</div>
@endsection