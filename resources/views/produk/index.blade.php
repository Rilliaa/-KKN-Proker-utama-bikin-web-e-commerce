@extends('adminlte::page')
@section('title', 'List Produk')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Produk</h1>
@stop
@section('content')
@if(session('error'))
    <div class="alert alert-danger text-center fixed-alert">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success text-center fixed-alert">
        {{ session('success') }}
    </div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <button class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#addProductModal">
                         <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                <div class="table-responsive">        
                    <table class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr style="text-align: center">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Link Produk</th>
                            <th>Foto Utama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        @foreach ($produk as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nama_produk }}</td>
                                <td>{{ $p->kategori->nama_kategori }}</td>
                                <td>{{ $p->deskripsi }}</td>
                                <td>
                                    <a href="{{ $p->link_produk }}" target="_blank">{{ $p->link_produk }}</a>
                                </td>            
                                <td style="text-align: center">
                                    <img src="{{ asset('storage/'.$p->foto_utama) }}" alt="{{ $p->nama_produk }}" class="img-fluid" width="100">
                                </td>                     
                                <td style="text-align: center">
                                    <button class="btn btn-success btn-edit"
                                        data-id="{{ $p->id_produk }}"
                                        data-nama="{{ $p->nama_produk }}"
                                        data-link="{{ $p->link_produk }}"
                                        data-kategori="{{ $p->kategori->nama_kategori }}"
                                        data-deskripsi="{{ $p->deskripsi }}"
                                        data-foto="{{ $p->foto_utama }}"
                                        data-toggle="modal"
                                        id="EditBtn"
                                        data-target="#editProductModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.produk-destroy', $p->id_produk) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.produk-show',$p->id_produk)}}" method="GET" style="display:inline;">
                                        <button class="btn btn-info">
                                            <i class="fas fa-search"></i> Detail 
                                        </button>
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
    </div>
    {{$produk->links()}}
</div>
<</div>

{{-- Modal tambah --}}
<div class="modal fade" id="addProductModal" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Produk:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="id_kategori" name="id_kategori">
                    </div>    
                    <div class="form-group">
                        <label for="link_produk">Link Produk:</label>
                        <input type="url" class="form-control" id="link_produk" name="link_produk" required pattern="https?://.+">
                        <small class="form-text text-muted">Masukkan link yang valid, dimulai dengan http:// atau https://</small>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Produk:</label>
                        <input type="file" class="form-control" id="foto" name="foto" required accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit / update --}}
<div class="modal fade" id="editProductModal" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <input type="hidden" id="edit_existing_foto" name="existing_foto">
                    <div class="form-group">
                        <label for="edit_nama">Nama Produk:</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi:</label>
                        <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kategori">Kategori:</label>
                        <select class="form-control" id="edit_kategori" name="edit_kategori" required>
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="edit_id_kategori" name="id_kategori">
                    </div>    
                    <div class="form-group">
                        <label for="edit_link_produk">Link Produk:</label>
                        <input type="url" class="form-control" id="edit_link_produk" name="edit_link_produk" required pattern="https?://.+">
                        <small class="form-text text-muted">Masukkan link yang valid, dimulai dengan http:// atau https://</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_foto">Foto Produk:</label>
                        <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('js')

<script>
$(document).ready(function() {

    // Jquery & ajax untuk melakukan store data dari modal tambah data --Start
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);


        // Cek tipe file pada form foto sebelum mengirim --Start
        let fileInput = $('#foto')[0];
        let file = fileInput.files[0];
        let validImageTypes = ["image/jpeg", "image/png", "image/jpg"];

        if ($.inArray(file.type, validImageTypes) < 0) {
            alert('File yang diunggah harus berupa gambar (jpeg, jpg, png).');
            return;
        }
        // Cek tipe file pada form foto sebelum mengirim --End

        $.ajax({
            type: 'POST',
            url: '{{ route("admin.produk-store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Berhasil Menambah Data');
                location.reload();
            },
            error: function(error) {
                console.log(error);
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    if (errors.foto) {
                        alert(errors.foto[0]);
                    }
                }
            }
        });
    });


    // Jquery untuk melakukan store data dari modal tambah data --End


     // Untuk validasi pada form link pada modal tambah dan edit --Start
     document.getElementById('addProductForm').addEventListener('submit', function(event) {
         const linkInput = document.getElementById('link_produk');
         if (!linkInput.checkValidity()) {
            event.preventDefault(); // Mencegah form submit jika link tidak valid
            alert('Silahkan masukkan link yang valid');
        }
    });

    document.getElementById('editProductForm').addEventListener('submit', function(event) {
        const linkInput = document.getElementById('edit_link_produk');
        if (!linkInput.checkValidity()) {
            event.preventDefault(); // Mencegah form submit jika link tidak valid
            alert('Silahkan masukkan link yang valid');
        }
    });
    // Untuk validasi pada form link pada modal tambah dan edit --End



    // Jquery untuk ngisi modal Edit --Start
    $('body').on('click', '#EditBtn', function() {
        let id = $(this).data('id');
        let nama_produk = $(this).data('nama');
        let deskripsi_produk = $(this).data('deskripsi');
        let link_produk = $(this).data('link');
        let nama_kategori = $(this).data('kategori');
        let foto_utama = $(this).data('foto');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama_produk;
        document.getElementById('edit_deskripsi').value = deskripsi_produk;
        document.getElementById('edit_link_produk').value = link_produk;
        document.getElementById('edit_id_kategori').value = nama_kategori;
        document.getElementById('edit_existing_foto').value = foto_utama; // untuk nilai input tersembunyi 
    });
// Jquery untuk ngisi modal Edit --End

    
    // Jquery untuk update data dari modal edit --Start
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route("admin.produk-update", ":id") }}'.replace(':id', id),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Berhasil Update Data', response);
                location.reload();
            },
            error: function(error) {
                console.log(error);
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    if (errors.foto) {
                        alert(errors.foto[0]);
                    }
                }
            }
        });
    });
});
    // Jquery untuk update data dari modal edit --End



 // Jquery untuk select2 kategori modal tambah --START
 $(document).ready(function(){
        $('#addProductModal').on('shown.bs.modal', function () {
            $('#kategori').select2({
                placeholder: 'Pilih kateogri',
                ajax: {
                    url: '{{ route("admin.kategori-search") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id_kategori,
                                    text: item.nama_kategori,
                                };
                            })
                        };
                    },
                    success: function(data){
                        console.log('Sukses mengambil data kategori :', data);
                    },
                    cache: true
                },
            });
        })
        $('#kategori').on('change', function() {
        let selectedValue = $(this).val();
        $('#id_kategori').val(selectedValue);
    });
    });
    // Jquery untuk select2 kategori modal tambah --END



    // Jquery untuk select2 kategori modal Edit --START
 $(document).ready(function(){
        $('#editProductModal').on('shown.bs.modal', function () {
            $('#edit_kategori').select2({
                placeholder: 'Pilih kateogri',
                ajax: {
                    url: '{{ route("admin.kategori-search") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id_kategori,
                                    text: item.nama_kategori,
                                };
                            })
                        };
                    },
                    success: function(data){
                        console.log('Sukses mengambil data kategori :', data);
                  
                    },
                    cache: true
                },
            });
        });
    });
    // Jquery untuk select2 kategori modal Edit --END



    // Menghilangkan notifikasi setelah 5 detik --Start
    setTimeout(function() {
        const alert = document.querySelector('.fixed-alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500); // Sesuaikan dengan durasi transition di CSS
        }
    }, 5000); // Durasi 5 detik
    // Menghilangkan notifikasi setelah 5 detik --End




    // Live Search
    
    // Live Search
</script>

@stop

