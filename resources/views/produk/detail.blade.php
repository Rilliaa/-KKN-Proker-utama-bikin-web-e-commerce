@extends('adminlte::page')
@section('title', 'Detail Produk')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Detail Produk</h1>
@stop

@section('content')

{{-- Halaman ini di atur pada ProdukController method show --}}
<style>
    /* untuk css nya bebas mau di letak di file yang sama atau terpisah, 
    ini rio sengaja letak di file yang sama karna malas buat file baru */
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
                        <button class="btn btn-info">Kembali</button>
                    </form> 
                </div>
                <div class="product-detail-container">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/'.$produk->foto_utama) }}" alt="{{ $produk->nama_produk }}">
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
                                    <td class="link-wrap"><a href="{{ $produk->link_produk }}" target="_blank">: {{ $produk->link_produk }}</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <form action="{{ route('admin.tambahan-index', $produk->id_produk) }}" method="GET" style="display:inline;">
                        <button class="btn btn-primary">Tambah Keterangan Tambahan</button>
                    </form> 
                </div>
                <table class="table table-hover table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>Deskripsi Tambahan</th>
                            <th>Foto Tambahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if($produk->tambahan)
                            <tr>
                                <td>{{ $produk->tambahan->deskripsi_tambahan }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$produk->tambahan->foto_tambahan) }}" alt="Foto Tambahan" class="product-image">
                                </td>
                                <td class="text-center">
                                    <i class="fas fa-check-circle status-icon text-success"></i>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    <i class="fas fa-times-circle status-icon text-danger"></i>
                                </td>
                            </tr>
                        @endif --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
