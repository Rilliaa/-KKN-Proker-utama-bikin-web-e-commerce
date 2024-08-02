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

    public function store(Request $request)
{
    $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'foto_tambahan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'deskripsi_tambahan' => 'nullable|string',
    ]);

    // Ensure at least one of deskripsi_tambahan or foto_tambahan is provided
    if (empty($request->deskripsi_tambahan) && !$request->hasFile('foto_tambahan')) {
        return response()->json([
            'success' => false,
            'message' => 'Harap mengisi setidaknya salah satu dari deskripsi atau foto tambahan.',
        ], 422);
    }

    // Save image file if present
    if ($request->hasFile('foto_tambahan')) {
        $filePath = $request->file('foto_tambahan')->store('produk_tambahan', 'public');
    }

    // Save data to database
    $tambahan = Tambahan::create([
        'id_produk' => $request->id_produk,
        'foto_tambahan' => isset($filePath) ? $filePath : null,
        'deskripsi_tambahan' => $request->deskripsi_tambahan,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil disimpan',
        'data' => $tambahan
    ], 201);
}

    
}
