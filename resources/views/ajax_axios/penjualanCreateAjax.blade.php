@extends('layouts.main.main')

@section('content')
<div class="page-header">
    <h3 class="page-title">Create Buku</h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"> <a href="{{ route('penjualan.ajax') }}">Penjualan (Ajax)</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Buku</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-lg-7 grid-margin stretch-card">        
        <div class="card">
            <div class="card-body">
                <div class="card-title">Tambahkan Ke Keranjang</div>
                <div class="card-description">Tambahkan barang yang akan dimasukkan ke dalam keranjang</div>
                <div class="form-group">
                    <label for="kode">Kode Barang</label>
                    <input type="text" id="kode" class="form-control" required maxlength="8">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" id="nama" class="form-control" required readonly maxlength="200">
                </div>
                <div class="form-group">
                    <label for="harga">Harga Satuan</label>
                    <input type="text" id="harga" class="form-control" data-harga="" required readonly maxlength="11" value="Rp 0">
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" id="jumlah" class="form-control" required max="999" value="0" disabled>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-row-reverse mt-5">                    
                    <button class="btn btn-gradient-primary btn-fw" id="tambahBarang" disabled>Tambahkan</button>
                </div>                   
            </div>
        </div>
    </div>
    <div class="col-lg-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between flex-column">
                {{-- <div class=""> --}}
                    <h1 class="display-2">
                        Total             
                    </h1>
                    <h1 class="display-2 flex-grow-1" id="total" data-total="">Rp 0</h1>         
                    <button class="btn btn-gradient-primary btn-lg mt-5" id="bayarBarang" disabled>Bayar</button>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="card-title">Penjualan</div>                    
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th style="width: 45%">Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th style="width: 15%">Jumlah</th>
                            <th style="width: 40%">Sub-Total</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="cartTable">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- <tr>
    <td>${cart.kode}</td>
    <td>${cart.nama}</td>
    <td>${cart.harga}</td>
    <td>${cart.jumlah}</td>
    <td>${cart.subtotal}</td>
</tr> --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let cart = [];
            // console.log(cart);
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 2
                }).format(number);
            }

            function renderTable() {
                let tbody = $('#cartTable');
                let total = 0;

                tbody.empty();
                $.each(cart, function(index, barang) {
                    let row = `
                    <tr>
                        <td>${barang.kode}</td>
                        <td>${barang.nama}</td>
                        <td>${barang.harga}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm jumlah" 
                           data-index="${index}" value="${barang.jumlah}" min="1" max="999">
                        </td>
                        <td>${barang.subtotal}</td>                        
                        <td>
                            <button type="button" class="btn btn-danger btn-hapus" data-index="${index}">
                                <i class="remove mdi mdi-close-circle-outline"></i>
                            </button>
                        </td>                        
                    </tr>
                    `;
                    total += barang.subtotal;
                    tbody.append(row);
                })

                $('#total').html(formatRupiah(total)).attr('data-total', total);
                if (total > 0) {
                    $('#bayarBarang').prop('disabled', false);
                } else {
                    $('#bayarBarang').prop('disabled', true);                    
                }
            }

            function pembayaran() {

                let total = $('#total').attr('data-total');
                
                $.ajax({
                    url: "{{ route('penjualan.ajax.store') }}",
                    type: "POST",
                    // contentType: "application/json",
                    data: {
                        _token: "{{ csrf_token() }}",                      
                        total: total,
                        barang: cart
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success'
                        })

                        cart = [];
                        renderTable();
                        $('#kode_barang').val('').focus().trigger('input');
                        $('#nama_barang').val('');
                        $('#harga_barang').val('Rp 0');
                        $('#jumlah').val('').trigger('input');
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: error.response.message,
                            icon: 'error'
                        })
                    }
                })
                
            }

            $('#kode').keypress(function (e) {
                if (e.which == 13) {                  
                    // e.preventDefault();
                    let kode = $(this);
                    let nama = $('#nama');
                    let harga = $('#harga');
                    let jumlah = $('#jumlah');
    
                    $.ajax({
                        url: "{{ route('penjualan.ajax.search') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode: kode.val()
                        },
                        success: function(response) {                            
                            kode.val(response.data.id_barang);
                            nama.val(response.data.nama);
                            harga.val(formatRupiah(response.data.harga)).attr("data-harga", response.data.harga);
                            jumlah.val(1).prop('disabled', false).trigger("input");
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                }
            });

            $('#cartTable').on('change input', '.jumlah' ,function(e) {
                let index = $(this).attr('data-index');
                let newJumlah = parseInt($(this).val());
                if (newJumlah < 1) {
                    newJumlah = 1;
                } else if (newJumlah > 999) {
                    newJumlah = 999;
                }

                cart[index].jumlah = newJumlah;
                cart[index].subtotal = newJumlah * cart[index].harga;
                if (e.type === 'change') {                    
                    renderTable();
                }
            });
            

            $('#kode').on('input', function() {                
                $('#nama').val('');
                $('#harga').val('Rp 0');
                $('#jumlah').val('0');
                
                $('#jumlah').prop('disabled', true);
                $('#tambahBarang').prop('disabled', true);
            });

            $('#jumlah').on('input', function () {
                if ($(this).val() > 999) {
                    $(this).val(999);
                };
                if ($(this).val() > 0) {
                    $('#tambahBarang').prop('disabled', false);                    
                    return;
                }
                $('#tambahBarang').prop('disabled', true);                
            });

            $('#tambahBarang').click(function() {
                let kode = $('#kode').val();
                let nama = $('#nama').val();
                let harga = parseInt($('#harga').attr("data-harga"));
                let jumlah = parseInt($('#jumlah').val());
                let subtotal = harga * jumlah;
                let btn = $(this);
                let btnText = btn.text();
                btn.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);

                let foundCart = cart.findIndex(barang => barang.kode === kode);            

                if (foundCart > -1) {
                    cart[foundCart].jumlah += jumlah;
                    cart[foundCart].subtotal += subtotal;
                } else {
                    cart.push({
                        kode: kode,
                        nama: nama,
                        harga: harga,
                        jumlah: jumlah,
                        subtotal: subtotal
                    });
                }
                
                setTimeout(function () {
                    renderTable()
                    btn.html(btnText);
                }, 1000);

                $('#kode').val('').trigger('input');
                $('#nama').val('');
                $('#harga').attr('data-harga', '').val('Rp 0');
                $('#jumlah').val(0).trigger('input');
                $('#kode').focus();
            });

            $('#cartTable').on('click', '.btn-hapus', function() {
                let index = $(this).attr('data-index');
                let namaBarang = cart[index].nama;

                Swal.fire({
                    title: 'Hapus Item?',
                    text: `Apakah Anda yakin ingin menghapus ${namaBarang} dari keranjang?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart.splice(index, 1);
                        renderTable();
                    }
                });
            });                        

            $('#bayarBarang').on('click', function(e) {
                e.preventDefault();
                let btn = $(this);
                let btnText = btn.text();
                btn.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);
                if (cart.length === 0) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Keranjang belanja masih kosong. Silakan tambahkan barang terlebih dahulu.',
                        icon: 'warning',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Proses Pembayaran',
                    text: 'Apakah semua barang dan jumlah sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Bayar!',
                    cancelButtonText: 'Batal'
                }).then((result)=>{
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            pembayaran()
                            btn.html(btnText)
                        }, 1000);
                    }
                })
            })
        })
    </script>
@endpush
@endsection