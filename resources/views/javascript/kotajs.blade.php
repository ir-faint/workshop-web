@extends('layouts.main.main')

@section('content')
@push('style')
    
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@endpush
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="mb-0">Tambah Kota</h4>
            </div>
            <div class="card-body">
                <div class="form-group d-flex">
                    <input type="text" id="inputKota" class="form-control mr-2" placeholder="Kota:"> <button class="btn btn-primary" id="btnAddKota">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    {{-- select --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="mb-0">Select</h4>
            </div>
            <div class="card-body">
                
                <div class="form-group mt-4">
                    <label>Select Kota:</label> <select id="selectKota1" class="form-select">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="mt-3">
                    <strong>Kota Terpilih: </strong> <span id="hasilKota1" class="text-primary">-</span> </div>
            </div>
        </div>
    </div>

    {{-- select2 --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="mb-0">select 2</h4>
            </div>
            <div class="card-body">
                
                <div class="form-group mt-4">
                    <label>Select Kota:</label> <select id="selectKota2" class="form-select" >
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="mt-3">
                    <strong>Kota Terpilih: </strong> <span id="hasilKota2" class="text-primary">-</span> </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // nambah select2
        $('#selectKota2').select2({
        theme: 'bootstrap-5'
    });
        
        // select nambah option
        $('#btnAddKota').click(function() {
            let kota = $('#inputKota').val();
            if (kota !== '') {
                let newOption = new Option(kota, kota, false, false);
                $('#selectKota1').append(new Option(kota, kota));
                $('#selectKota2').append(newOption).trigger('change');
                $('#inputKota').val('');
                $('#inputKota2').val('');
            }
        });
        
        // nampilin select
        $('#selectKota1').change(function() {
            $('#hasilKota1').text($(this).val()); 
        });
        
        // nampilin select 2
        $('#selectKota2').change(function() {
            $('#hasilKota2').text($(this).val());
        });
    });
</script>
@endpush

@endsection