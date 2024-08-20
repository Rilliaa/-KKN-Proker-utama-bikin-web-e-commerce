<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tglskrng = Carbon::today()->format('d-m-y');
        $jumlahProduk = DB::table('produk')->count();
        $jumlahKategori = DB::table('kategori')->count();
        $keterangan_tambahan = Db::table('produk_tambahan')->count();
        $foto_tambahan = Db::table('produk_tambahan')->count('foto_tambahan');
        $deskripsi_tambahan = Db::table('produk_tambahan')->count('deskripsi_tambahan');
     return view('home', compact(
        'tglskrng',
        'jumlahProduk', 
        'jumlahKategori',
        'foto_tambahan',
        'deskripsi_tambahan',
        'keterangan_tambahan'
    ));
    }
   
}



