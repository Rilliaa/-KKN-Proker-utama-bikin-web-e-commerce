@extends('adminlte::page')
@section('title', 'List Kategori')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Kategori</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addCategoryModal"><i class="fas fa-plus mr-1"></i> Tambah Kategori</button>
                <table class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_kategori }}</td>
                                <td>{{ $data->kode_kategori }}</td>
                                <td>{{ $data->deskripsi_kategori }}</td>
                                <td>
                                    <button class="btn btn-success btn-edit"  
                                    data-id="{{ $data->id_kategori }}" 
                                    data-nama="{{ $data->nama_kategori }}" 
                                    data-kode="{{ $data->kode_kategori }}" 
                                    data-deskripsi="{{ $data->deskripsi_kategori }}"
                                    data-toggle="modal"
                                    id="btnEdit"
                                    data-target="#editCategoryModal">
                                    <i class="fas fa-edit"></i>    
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.kategori-destroy', $data->id_kategori) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_kategori">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi_kategori" name="deskripsi_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_kategori">Kode</label>
                        <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" required>
                    </div>
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_deskripsi_kategori">Deskripsi</label>
                        <input type="text" class="form-control" id="edit_deskripsi_kategori" name="deskripsi_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kode_kategori">Kode</label>
                        <input type="text" class="form-control" id="edit_kode_kategori" name="kode_kategori" required>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add category
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.kategori-store") }}',
            data: $(this).serialize(),
            success: function(response) {
                alert('Berhasil Menambah Data');
                location.reload();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    // Edit category modal
    $('body').on('click','#btnEdit' ,function() {
        let id = $(this).data('id');
        let nama_kategori = $(this).data('nama');
        let kode_kategori = $(this).data('kode');
        let deskripsi_kategori = $(this).data('deskripsi');

        // console.log("kode Kategori: ", kode_kategori);
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama_kategori').value = nama_kategori;
        document.getElementById('edit_kode_kategori').value = kode_kategori;
        document.getElementById('edit_deskripsi_kategori').value = deskripsi_kategori;
        
    });

    // Edit category
    $('#editCategoryForm').on('submit', function(e) {
    e.preventDefault();
    var id = $('#edit_id').val();
    $.ajax({
        type: 'PUT',
        url: '{{ route("admin.kategori-update", ":id") }}'.replace(':id', id),
        data: $(this).serialize(),
        success: function(response) {
            alert('Berhasil Update Data');
            location.reload();
        },
        error: function(error) {
            console.log(error);
        }
    });
});

});
</script>
@stop
