@extends('layouts.main.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Frontend CRUD Barang</h4>
        
        <form id="formAddBarang" class="mb-4">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" id="addNama" class="form-control" placeholder="Nama Barang" required>
                </div>
                <div class="col-md-5">
                    <input type="number" id="addHarga" class="form-control" placeholder="Harga Barang" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-block" id="btnAdd">Submit</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-hover" id="tableBarang">
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalBarang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update/Destroy Barang</h5>
            </div>
            <div class="modal-body">
                <form id="formEditBarang">
                    <div class="form-group">
                        <label>ID Barang</label>
                        <input type="text" id="editId" class="form-control" readonly> </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" id="editNama" class="form-control" required> </div>
                    <div class="form-group">
                        <label>Harga Barang</label>
                        <input type="number" id="editHarga" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnDestroy">Destroy</button> <button type="button" class="btn btn-primary" id="btnUpdate">Update</button> </div>
        </div>
    </div>
</div>

@push('script')
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentRow;
        let idCounter = 1;

        // hover css
        $('#tableBarang tbody').css('cursor', 'pointer');

        // create barang
        $('#btnAdd').click(function() {
            let form = document.getElementById('formAddBarang');
            if (form.checkValidity()) {
                let btn = $(this);
                let originalText = btn.text();
                btn.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);

                setTimeout(function() { 
                    let id = "BRG-" + idCounter++;
                    let nama = $('#addNama').val();
                    let harga = $('#addHarga').val();

                    let newRow = `<tr data-id="${id}">
                        <td class="col-id">${id}</td>
                        <td class="col-nama">${nama}</td>
                        <td class="col-harga">${harga}</td>
                    </tr>`;
                    $('#tableBarang tbody').append(newRow);
                    
                    $('#addNama').val('');
                    $('#addHarga').val('');
                    btn.html(originalText).prop('disabled', false);
                }, 1000);
            } else {
                form.reportValidity();
            }
        });

        // open modal
        $('#tableBarang tbody').on('click', 'tr', function() {
            currentRow = $(this);
            $('#editId').val(currentRow.find('.col-id').text());
            $('#editNama').val(currentRow.find('.col-nama').text());
            $('#editHarga').val(currentRow.find('.col-harga').text());
            $('#modalBarang').modal('show');
        });

        // update modal
        $('#btnUpdate').click(function() {
            let form = document.getElementById('formEditBarang');
            if (form.checkValidity()) {
                let btn = $(this);
                let btnOther = $('#btnDestroy');

                let originalText = btn.text();
                let originalTextOther = btnOther.text();

                btn.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);
                btnOther.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);

                setTimeout(function() {
                    currentRow.find('.col-nama').text($('#editNama').val());
                    currentRow.find('.col-harga').text($('#editHarga').val());
                    $('#modalBarang').modal('hide');
                    btn.html(originalText).prop('disabled', false); 
                    btnOther.html(originalTextOther).prop('disabled', false); 
                }, 1000)
            } else {
                form.reportValidity();
            }
        });

        // delete modal
        $('#btnDestroy').click(function() {
            let btnSelected = $(this);
            let btnOther = $('#btnUpdate');

            let originalText = btnSelected.text();
            let originalTextOther = btnOther.text();

            btnSelected.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);
            btnOther.html('<span class="spinner-border spinner-border-sm"></span><span> Loading...</span>').prop('disabled', true);

            setTimeout(function() {
                currentRow.remove();
                $('#modalBarang').modal('hide');
                btnSelected.html(originalText).prop('disabled', false); 
                btnOther.html(originalTextOther).prop('disabled', false); 
            }, 1000);
        });
    });
</script>

@endpush
@endsection