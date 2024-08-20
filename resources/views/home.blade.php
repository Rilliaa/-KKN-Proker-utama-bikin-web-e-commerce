@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1 class="m-0 text-dark d-flex justify-content-between">Dashboard Admin</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="mr-auto">Selamat Datang, <strong style="color: #ff9e2a;">{{ Auth::user()->name }}</strong></p><br>
                    <span style="color: navy; text-weight:bold;">Sekarang Tanggal, <strong><i>{{$tglskrng}}</i></strong> Selamat Bekerja!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6" onclick="window.location='{{ route('admin.produk-index') }}'" style="cursor: pointer;">
        <div class="card bg-primary text-white shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Jumlah Produk</h5>
                    <p class="card-text">{{ $jumlahProduk }} produk</p>
                </div>
                <i class="fas fa-box fa-3x" style="margin-left: auto;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6" onclick="window.location='{{ route('admin.kategori-index') }}'" style="cursor: pointer;">
        <div class="card bg-success text-white shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Jumlah Kategori</h5>
                    <p class="card-text">{{ $jumlahKategori }} kategori</p>
                </div>
                <i class="fas fa-list-alt fa-3x" style="margin-left: auto;"></i>
            </div>
        </div>
    </div>
    

    <div class="col-md-6">
        <div class="card bg-warning text-white shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Jumlah Foto Tambahan</h5>
                    <p class="card-text">{{ $foto_tambahan }} foto tambahan</p>
                </div>
                <i class="fas fa-camera fa-3x" style="margin-left: auto;"></i> <!-- Simbol Foto -->
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-info text-white shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Jumlah Deskripsi Tambahan</h5>
                    <p class="card-text">{{ $deskripsi_tambahan }} deskripsi tambahan</p>
                </div>
                <i class="fas fa-book fa-3x" style="margin-left: auto;"></i> <!-- Simbol Buku atau Catatan -->
            </div>
        </div>
    </div>

    <div class="col-12"> <!-- Menggunakan col-12 agar card ini memanjang penuh ke kanan -->
        <div class="card bg-danger text-white shadow">
            <div class="card-body d-flex align-items-center">
                <div>
                    <h5 class="card-title">Total Keterangan Tambahan</h5>
                    <p class="card-text">{{ $keterangan_tambahan }} keterangan tambahan</p>
                </div>
                <i class="fas fa-clipboard-list fa-3x" style="margin-left: auto;"></i> <!-- Simbol Keterangan Tambahan -->
            </div>
        </div>
    </div>
</div>
@stop
