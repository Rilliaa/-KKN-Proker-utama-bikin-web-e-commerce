@extends('adminlte::page')

@section('title', 'Detail Keterangan Tambahan Produk')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Keterangan Tambahan, <span class="btn btn-warning">{{ $produk->nama_produk }}</span></h1>
@stop

@section('content')
{{-- Halaman ini di atur oleh TambahaController method index  --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<div class="mb-3">
    <form action="{{ route('admin.produk-show', $produk->id_produk) }}" method="GET" style="display:inline;">
        <button class="btn btn-info">Kembali</button>
    </form> 
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Menampilkan Deskripsi Tambahan Jika Ada -->
                @if($produk->tambahan->whereNotNull('deskripsi_tambahan')->isNotEmpty())
                    <h2>Deskripsi Tambahan:</h2>
                    @foreach($produk->tambahan as $tambahan)
                        @if($tambahan->deskripsi_tambahan)
                            <div class="mb-4">
                                <label for="deskripsi_editor_{{ $tambahan->id_tambahan }}" class="form-label">Deskripsi Tambahan</label>
                                <!-- Textarea untuk CKEditor -->
                                <textarea id="deskripsi_editor_{{ $tambahan->id_tambahan }}" class="form-control">{{ $tambahan->deskripsi_tambahan }}</textarea>
                            </div>
                            @break <!-- Hanya menampilkan satu deskripsi tambahan -->
                        @endif
                    @endforeach
                @endif

                <!-- Menampilkan Foto Tambahan Jika Ada -->
                @if($produk->tambahan->whereNotNull('foto_tambahan')->isNotEmpty())
                    <h2>Foto Tambahan:</h2>
                    <div class="row">
                        @foreach($produk->tambahan as $tambahan)
                            @if($tambahan->foto_tambahan)
                                <div class="col-md-3 mb-4">
                                    <div class="image-container">
                                        <img id="preview_foto_{{ $tambahan->id_tambahan }}" src="{{ asset('storage/'.$tambahan->foto_tambahan) }}" alt="Foto Tambahan" class="img-fluid img-thumbnail" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal_{{ $tambahan->id_tambahan }}">
                                    </div>
                                </div>

                               <!-- Modal untuk menampilkan gambar -->
                                <div class="modal fade" id="imageModal_{{ $tambahan->id_tambahan }}" tabindex="-1" aria-labelledby="imageModalLabel_{{ $tambahan->id_tambahan }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel_{{ $tambahan->id_tambahan }}">Foto Tambahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modal_foto_{{ $tambahan->id_tambahan }}" src="{{ asset('storage/'.$tambahan->foto_tambahan) }}" alt="Foto Tambahan" class="img-fluid">
                                                
                                                <!-- Form untuk mengupdate foto -->
                                                <div class="mb-3">
                                                    <label for="foto_tambahan_{{ $tambahan->id_tambahan }}" class="form-label">Update Foto Tambahan</label>
                                                    <input type="file" accept="image/*" name="foto_tambahan" class="form-control" id="foto_tambahan_{{ $tambahan->id_tambahan }}" data-id="{{ $tambahan->id_tambahan }}">
                                                </div>

                                             <!-- Form untuk menghapus foto -->
                                                <form action="{{ route('admin.tambahan-destroy', $tambahan->id_tambahan) }}" method="POST" style="margin-top: 10px;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus gambar ini? Deskripsi tidak akan dihapus.')">Hapus Gambar</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                <div class="mb-3;">
                    <button id="updateDataButton" class="btn btn-success" disabled>
                        <i class="fas fa-edit"></i>    Update Data
                    </button>
                    <form action="{{ route('admin.tambahan-delete-all', $produk->id_produk) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button id="deleteAllButton" class="btn btn-danger ml-2" onclick="return confirm('Anda yakin ingin menghapus semua keterangan tambahan? Ini akan menghapus semua deskripsi dan foto tambahan.')">
                            <i class="fas fa-trash"></i> Delete Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    let initialEditorData;
    let editor;
    let tempPhotoData = {}; // Variabel untuk menyimpan data foto sementara

    @foreach($produk->tambahan as $tambahan)
        @if($tambahan->deskripsi_tambahan)
            ClassicEditor
                .create(document.querySelector('#deskripsi_editor_{{ $tambahan->id_tambahan }}'), {
                    toolbar: ['bold', 'italic', 'link', 'numberedList', 'bulletedList']
                })
                .then(newEditor => {
                    editor = newEditor;
                    initialEditorData = editor.getData();
                    editor.model.document.on('change:data', () => {
                        // Aktifkan tombol jika data editor berubah
                        if (editor.getData() !== initialEditorData) {
                            document.getElementById('updateDataButton').disabled = false;
                        } else {
                            document.getElementById('updateDataButton').disabled = true;
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            @break <!-- Inisialisasi hanya untuk satu deskripsi tambahan -->
        @endif
    @endforeach

    // Memantau perubahan pada input file
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            let tambahanId = this.getAttribute('data-id');
            let previewImage = document.getElementById('preview_foto_' + tambahanId);
            let modalImage = document.getElementById('modal_foto_' + tambahanId);
            let file = this.files[0];
            let reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                modalImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
            tempPhotoData[tambahanId] = file; // Simpan data foto sementara
            document.getElementById('updateDataButton').disabled = false;
        });
    });

    // Handle Update Data button click
    document.getElementById('updateDataButton').addEventListener('click', function() {
    let deskripsi = editor.getData();
    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('deskripsi_tambahan', deskripsi);

    // Kirim semua foto yang diubah berdasarkan ID tambahan
    for (let id in tempPhotoData) {
        formData.append('foto_tambahan[' + id + ']', tempPhotoData[id]); // Menggunakan array untuk mengirim data berdasarkan ID
    }

    fetch('{{ route("admin.tambahan-update", $tambahan->id_tambahan) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data berhasil diperbarui');
            document.getElementById('updateDataButton').disabled = true;
            location.reload(); // Reload halaman setelah update berhasil
        } else {
            alert('Gagal memperbarui data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});





</script>
@stop