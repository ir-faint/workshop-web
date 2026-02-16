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
                                    <button type="button" class="btn btn-inverse-warning btn-sm btn-icon">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-inverse-danger btn-sm btn-icon">
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
@endsection