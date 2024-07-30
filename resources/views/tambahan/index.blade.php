@extends('adminlte::page')
@section('title', 'Tambahan Produk')
@section('content_header')
    <h1 class="m-0 text-dark">Halaman Tambahan Produk {{$produk->nama_produk}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$produk->foto_utama) }}" alt="{{ $produk->nama_produk }}">
                        </td>
                    </tr>
                </table>
        
            </div>
        </div>
    </div>
</div>
@stop
