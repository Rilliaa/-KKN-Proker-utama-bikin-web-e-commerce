@extends('adminlte::page')
@section('title', 'Detail Produk')

@section('content_header')
    <h1 class="m-0 text-dark">Halaman Detail Produk</h1>
@stop

@section('content')
{{-- Halaman ini di atur pada ProdukController method show --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">


<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .product-detail-container {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }
    .product-image-container {
        flex-shrink: 0;
        width: 200px; /* Untuk ukuran foto */
        height: auto;
    }
    .product-image-container img {
        width: 100%;
        height: auto;
        border-radius: 30px;
    }
    .product-details {
        flex-grow: 1;
    }
    .status-icon {
        font-size: 24px;
    }
    .link-wrap {
        word-break: break-all;
    }
    .link-wrap a {
        display: block;
    }
    .table-borderless td, 
    .table-borderless th {
        padding: 2px; 
        margin: 0; 
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <form action="{{ route('admin.produk-index') }}" method="GET" style="display:inline;">
                        <button class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </form>
                </div>
                <div class="product-detail-container">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $produk->foto_utama) }}" alt="{{ $produk->nama_produk }}" 
                             style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
                    </div>
                    <div class="product-details">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>Nama Produk</td>
                                    <td>: {{ $produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>: {{ $produk->deskripsi }}</td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>: {{ $produk->kategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td>Link Produk</td>
                                    <td class="link-wrap">
                                        <a href="{{ $produk->link_produk }}" target="_blank">
                                            :{{ $produk->link_produk }}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk memperbesar gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset('storage/'.$produk->foto_utama) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addInfoModal">
                        <i class="fas fa-plus"></i> Tambah Keterangan Tambahan
                    </button>
                </div>
                <table class="table table-hover table-bordered table-stripped">
                    <thead>
                        <tr style="text-align: center">
                            <th>No</th>
                            <th>Deskripsi Tambahan</th>
                            <th>Kategori Tambahan</th>
                            <th>Foto Tambahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $deskripsiTersedia = $produk->tambahan->contains(function ($value) {
                                return !empty($value->deskripsi_tambahan);
                            });
                            $kategoriTersedia = $produk->tambahan->contains(function ($value) {
                                return !empty($value->id_kategori);
                            });
                            $fotoTambahanCount = $produk->tambahan->whereNotNull('foto_tambahan')->count();
                            $totalFotoTambahan = $produk->tambahan->count(); // total rows
                        @endphp
                    
                        @foreach ($produk->tambahan as $index => $tambahan)
                            <tr style="text-align: center">
                                <td>{{ $index + 1 }}</td>
                                {{-- Ceklis Deskripsi Tambahan, hanya tampilkan di baris pertama dan rowspan sesuai dengan jumlah tambahan --}}
                                @if ($index === 0)
                                    <td rowspan="{{ max($totalFotoTambahan, 1) }}" style="vertical-align: middle;">
                                        @if ($deskripsiTersedia)
                                            <i class="fas fa-check-circle status-icon text-success"></i>
                                        @else
                                            <i class="fas fa-times-circle status-icon text-danger"></i>
                                        @endif
                                    </td>
                                @endif

                            @if ($index === 0)
                                <td rowspan="{{ max($totalFotoTambahan, 1) }}" style="vertical-align: middle;">
                                    @if ($kategoriTersedia)
                                        <i class="fas fa-check-circle status-icon text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle status-icon text-danger"></i>
                                    @endif
                                </td>
                            @endif

                                <td>
                                    @if (!empty($tambahan->foto_tambahan))
                                        <i class="fas fa-check-circle status-icon text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle status-icon text-danger"></i>
                                    @endif
                                </td>
                                @if ($index === 0)
                                    <td class="text-center" rowspan="{{ max($totalFotoTambahan, 1) }}" style="padding: 70px 0;">
                                        <a href="{{ route('admin.tambahan-index', $produk->id_produk) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i> Detail Keterangan
                                        </a>
                                        <br>
                                        <form action="{{ route('admin.tambahan-delete-all', $produk->id_produk) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button id="deleteAllButton" class="btn btn-danger mt-2" onclick="return confirm('Anda yakin ingin menghapus semua keterangan tambahan? Ini akan menghapus semua deskripsi dan foto tambahan.')">
                                                <i class="fas fa-trash"></i> Hapus Data
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @if ($produk->tambahan->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">
                                    <strong>Belum ada deskripsi atau foto tambahan</strong>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menambah keterangan tambahan -->
<div class="modal fade" id="addInfoModal" role="dialog" aria-labelledby="addInfoModalLabel" aria-hidden="true">
    <<div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInfoModalLabel">Tambah Keterangan Tambahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="addTambahan">
                    @csrf
                    <div class="mb-3">
                        <label for="foto_tambahan" class="form-label">Foto tambahan (Maks.4)</label>
                        <input type="file" name="foto_tambahan" class="form-control" id="foto_tambahan" accept="image/*">
                        <input type="hidden" id="id_produk" value="{{ $produk->id_produk }}">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <select class="form-control" id="kategori" name="kategori">
                            <option value=""></option>
                        </select>
                        <input type="hidden" class="form-control" id="id_kategori" name="id_kategori">
                    </div>    
                    <div class="mb-3">
                        <label for="deskripsi_tambahan" class="form-label">Deskripsi Tambahan</label>
                        <input id="deskripsi_tambahan" type="hidden" name="deskripsi_tambahan">
                        <textarea id="deskripsi_editor" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="simpanBtn" disabled>Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>



@stop

@section('js')
<script>
    // Untuk text editor pada modal tambah --Start
    let editor;
    ClassicEditor
        .create(document.querySelector('#deskripsi_editor'), {
            toolbar: ['bold', 'italic', 'link', 'numberedList', 'bulletedList']
        })
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.log(error);
        });
    // Untuk text editor pada modal tambah --End

    // Fungsi untuk mengecek apakah tombol "Simpan" bisa diaktifkan
    function checkInput() {
        let isFileInputFilled = $('#foto_tambahan').val() !== '';
        let isDescriptionFilled = editor.getData().trim() !== '';
        let isCategorySelected = $('#kategori').val() !== ''; // Cek apakah kategori sudah dipilih
        
        if (isFileInputFilled || isDescriptionFilled || isCategorySelected) {
            $('#simpanBtn').prop('disabled', false);
        } else {
            $('#simpanBtn').prop('disabled', true);
        }
    }

    // Mengecek kondisi saat modal ditampilkan --Start
    $('#addInfoModal').on('show.bs.modal', function () {
        let deskripsiTersedia = @json($deskripsiTersedia);
        let kategoriTersedia = @json($kategoriTersedia);
        let fotoTambahanCount = @json($fotoTambahanCount);
        let maxFotoCount = 4;

        // Mengecek apakah deskripsi tambahan sudah ada
        if (deskripsiTersedia) {
            editor.enableReadOnlyMode('deskripsi_tambahan');
            $('#deskripsi_tambahan').prop('disabled', true);
            alert('Deskripsi tambahan sudah ada, Anda tidak bisa menambahkannya lagi.');
        } else {
            editor.disableReadOnlyMode('deskripsi_tambahan');
            $('#deskripsi_tambahan').prop('disabled', false);
        }

        // Mengecek apakah kategori tambahan sudah ada
        if (kategoriTersedia) {
            $('#kategori').prop('disabled', true);
            alert('Kategori tambahan sudah ada');
        } else {
            $('#kategori').prop('disabled', false);
        }

        // Mengecek apakah jumlah foto tambahan sudah mencapai batas maksimum
        if (fotoTambahanCount >= maxFotoCount) {
            $('#foto_tambahan').prop('disabled', true);
            alert('Anda sudah mencapai batas maksimal 4 foto tambahan. Tidak bisa menambah foto lagi.');
        } else {
            $('#foto_tambahan').prop('disabled', false);
        }
    });
    // Mengecek kondisi saat modal ditampilkan --End

    // Ajax untuk store data ke database --Start
    $('#addTambahan').on('submit', function(e) {
        e.preventDefault();

        // Memasukkan data text editor ke dalam input hidden
        document.querySelector('#deskripsi_tambahan').value = editor.getData();

        // Cek tipe file yang diinput pada form gambar --Start
        let fileInput = $('#foto_tambahan')[0];
        let file = fileInput.files[0];
        let validImageTypes = ["image/jpeg", "image/png", "image/jpg"];
        
        if (file && $.inArray(file.type, validImageTypes) < 0) {
            alert('File yang diunggah harus berupa gambar (jpeg, jpg, png).');
            return;
        }
        // Cek tipe file yang diinput pada form gambar --End
        
        let formData = new FormData(this);
        formData.append('id_produk', document.getElementById('id_produk').value);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            type: 'POST',
            url: '{{ route("admin.tambahan-store") }}',
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
    // Ajax untuk store data ke database --End

    // Event listeners untuk menghidupkan atau menonaktifkan tombol simpan pada modal --Start
    $(document).ready(function() {
        // Cek inputan file
        $('#foto_tambahan').on('change', function() {
            checkInput();
        });

        // Cek perubahan pada CKEditor
        editor.model.document.on('change:data', () => {
            checkInput();
        });

        // Cek perubahan pada select2 kategori
        $('#kategori').on('change', function() {
            checkInput();
        });

        // Reset form dan tombol saat modal ditutup
        $('#addInfoModal').on('hide.bs.modal', function () {
            $('#foto_tambahan').val('');
            editor.setData('');
            $('#kategori').val(null).trigger('change'); // Reset kategori select2
            $('#simpanBtn').prop('disabled', true);
        });
    });
    // Event listeners untuk menghidupkan atau menonaktifkan tombol simpan pada modal --End

</script>

<script>

     // Jquery untuk select2 kategori modal Tmabah --START
     $(document).ready(function(){
        $('#addInfoModal').on('shown.bs.modal', function () {
            $('#kategori').select2({
                placeholder: 'Pilih kateogri',
                dropdownParent: $('#addInfoModal'), //untuk dropdown form list pada select2, ini spesial karna biasanya tidak menggunakan ini
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
             $('#kategori').on('change', function() {
        let selectedValue = $(this).val();
        $('#id_kategori').val(selectedValue);
    });
    });
    // Jquery untuk select2 kategori modal Tambah --END
  


</script>
<style>
      .select2-container { 
        /* ini untuk mengatur layer select2 pada modal
        Masalah ini bisa jadi kombinasi antara z-index, pengaturan modal, inisialisasi dinamis, dan interaksi elemen di halaman. 
        */
    z-index: 9999 !important;
}
</style>

@stop
