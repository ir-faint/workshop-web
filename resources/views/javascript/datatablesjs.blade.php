@extends('layouts.main.main')

@section('content')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
@endpush
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Frontend CRUD Barang (DataTable)</h4>
        
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
                <h5 class="modal-title">Ubah/Hapus Barang</h5>
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
                <button type="button" class="btn btn-danger" id="btnHapus">Hapus</button> <button type="button" class="btn btn-primary" id="btnUbah">Ubah</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#tableBarang').DataTable();
        
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

                    table.row.add([
                        id,
                        nama,
                        harga
                    ]).draw(false);
                    
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
            if (table.row(this).data() !== undefined) {
                currentRow = table.row(this);
                let rowData = currentRow.data();

                $('#editId').val(rowData[0]);
                $('#editNama').val(rowData[1]);
                $('#editHarga').val(rowData[2]);
                $('#modalBarang').modal('show');
            }
        });

        // update modal
        $('#btnUbah').click(function() {
            let form = document.getElementById('formEditBarang');
            if (form.checkValidity()) {
                let updatedId = $('#editId').val();
                let updatedNama = $('#editNama').val();
                let updatedHarga = $('#editHarga').val();

                currentRow.data([updatedId, updatedNama, updatedHarga]).draw(false);
                $('#modalBarang').modal('hide');
            } else {
                form.reportValidity();
            }
        });

        // delete modal
        $('#btnHapus').click(function() {
            currentRow.remove().draw(false);
            $('#modalBarang').modal('hide'); 
        });
    });
</script>

@endpush
@endsection