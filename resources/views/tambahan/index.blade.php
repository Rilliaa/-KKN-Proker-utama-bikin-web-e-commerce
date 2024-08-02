@extends('adminlte::page')

@section('title', 'Tambahan Produk')

@section('content_header')
    <h1 class="m-0 text-dark">Tambahan keterangan untuk produk, <span class="btn btn-warning">{{$produk->nama_produk}}</span></h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="foto_tambahan" class="form-label">Post Image</label>
                        <input type="file" name="foto_tambahan" class="form-control" id="foto_tambahan">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_tambahan" class="form-label">Deskripsi Tambahan</label>
                        <input id="deskripsi_tambahan" type="hidden" name="deskripsi_tambahan">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')

<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#deskripsi_tambahan'), {
            toolbar: [
                'bold', 
                'italic',
                'link', 
                'numberedList',
                'bulletedlist'

            ]
        })
        .catch(error => {
            console.log(error);
        });
</script>

@stop
