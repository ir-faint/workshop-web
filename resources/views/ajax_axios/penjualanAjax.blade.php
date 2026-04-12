@extends('layouts.main.main')

@section('content')
{{-- @push('style')
    <style>
        .detail-row {
            border-left: 5px solid #b66dff;
            box-shadow: inset 0px 5px 10px -5px rgba(0,0,0,0.1);
        }
    </style>
@endpush --}}
    
<div class="page-header">
    <h3 class="page-title">Penjualan (Ajax)</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Penjualan (Ajax)</li>
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
                    <div class="card-title">Penjualan</div>
                    <a href="{{ route('penjualan.ajax.create') }}" class="btn btn-sm btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Penjualan
                    </a>
                </div>
                <table class="table table-hover" id="penjualanTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Kode Penjualan</th>
                            <th>Dibuat Pada Tgl</th>
                            <th>Diubah Pada Tgl</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan as $p)
                            <tr data-id="{{ $p->id_penjualan }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->id_penjualan}}</td>
                                <td>{{ $p->created_at}}</td>
                                <td>{{ $p->updated_at}}</td>
                                <td>{{ $p->total}}</td>
                                <td style="width: 1%"><i class="mdi mdi-chevron-down"></i></td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="align-middle text-center">No Datas Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         $(document).ready(function () {
            $('#penjualanTable tbody').children().css('cursor', 'pointer');
            $('#penjualanTable tbody').on('mouseenter mouseleave',  '.detail-row', function() {
                $('#penjualanTable').toggleClass('table-hover')
            });
            $('#penjualanTable tbody').on('click', 'tr', function() {
                // let btn = $(this);
                let row = $(this);
                let id = row.data('id');
                let nextRow = row.next('.detail-row');
                let url = "{{ route('penjualan.ajax.getDetails', ':id') }}";
                url = url.replace(':id', id);

                if (nextRow.length) {
                    nextRow.toggle();
                    row.find('i').toggleClass('mdi-chevron-down mdi-chevron-up');
                    return;
                }
                
                
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let details = response.data;
                        console.log(details);
                        let detailHtml = `
                            <tr class="detail-row">
                                <td colspan="6">
                                    <div class="p-3">
                                        <h6><strong>Daftar Barang Transaksi #${id}</strong></h6>
                                        <table class="table table-sm table-bordered mt-2">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Barang</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
                        
                        details.forEach(item => {
                            detailHtml += `
                                <tr>
                                    <td>${item.barang.nama}</td>
                                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.barang.harga)}</td>
                                    <td>${item.jumlah}</td>
                                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                                </tr>`;
                        });
                        detailHtml += `</tbody></table></div></td></tr>`;
                        
                        row.after(detailHtml);
                        // row.next('.detail-row').toggle('slow');
                        row.find('i').toggleClass('mdi-chevron-down mdi-chevron-up');
                        // row.find('i').removeClass('mdi-chevron-down').addClass('mdi-chevron-up');
                    },
                    error: function() {
                        console.error(error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal mengambil detail barang',
                            icon: 'error'
                        });
                    }

                })
            });
         })
    </script>
@endpush
@endsection