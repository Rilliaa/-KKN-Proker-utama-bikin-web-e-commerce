<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        // untuk mengatur tampilan pada kategori/index.blade.php
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }
    public function store(Request $request)
    {
        // Untuk store data dari modal  kategori/index.blade.php ke db
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:255',
            'deskripsi_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($request->all());

        return response()->json(['success' => 'Kategori berhasil ditambahkan.']);
    }

    public function update(Request $request, $id_kategori)
    {
        //  update data dari modal edit kategori/index.blade.php ke db
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:255',
            'deskripsi_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::find($id_kategori);
        $kategori->update($request->all());

        return response()->json(['success' => 'Kategori berhasil diupdate.']);
    }

    public function destroy($id_kategori)
    {
        // hapus data kategori kategori/index.blade.php
        Kategori::destroy($id_kategori);
    
        return back()->with(['success' => 'Kategori berhasil dihapus.']);
    }

    public function search(Request $request)
    {
        // untuk search kategori menggunakan select2  dari produk/index.blade.php
        $data = Kategori::where('nama_kategori','LIKE','%'.request('q').'%')->orderBy("nama_kategori","asc")->get();
        return response()->json($data);
    }

    // public function dropdown(Request $request)
    // {
        // kmrn untuk dropdown id_kategori based on nama kategori, tapi sekarang udah ga dipake
    //     $kategori = $request->kategori;
    //     $id_kategori = Kategori::where('nama_kategori',$kategori)->get('id_kategori');
    //     dd($id_kategori);
    //     return response()->json($id_kategori);

    // }
    
}