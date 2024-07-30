<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tambahan;
use App\Models\Produk;

class TambahanController extends Controller
{
    public function index($id_produk)
    {
        // untuk mengatur halaman tambahan/index.blade.php
        $produk = Produk::where('id_produk',$id_produk)->first();
        return view('tambahan.index',compact('produk'));
    }
}
