<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tambahan;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TambahanController extends Controller
{
    public function index($id_produk)
    {
        // untuk mengatur halaman tambahan/index.blade.php
        $tambahan = Tambahan::where('id_produk', $id_produk)->first();
        $kategori = Kategori::orderby('nama_kategori','asc')->get();
        $produk = Produk::with('tambahan')->where('id_produk',$id_produk)->first();
        return view('tambahan.index',compact('produk','tambahan','kategori'));
        // return view('tambahan.index',compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'foto_tambahan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_tambahan' => 'nullable|string',
            'id_kategori' => 'nullable',
        ]);
    
        // Ensure at least one of deskripsi_tambahan, foto_tambahan, or id_kategori is provided
        if (empty($request->deskripsi_tambahan) && !$request->hasFile('foto_tambahan') && empty($request->id_kategori)) {
            return response()->json([
                'success' => false,
                'message' => 'Harap mengisi setidaknya salah satu dari deskripsi, foto, atau kategori tambahan.',
            ], 422);
        }
    
        // Save image file if present
        if ($request->hasFile('foto_tambahan')) {
            $filePath = $request->file('foto_tambahan')->store('storage/produk_tambahan', 'public');
        }
    
        // Save data to database
        $tambahan = Tambahan::create([
            'id_produk' => $request->id_produk,
            'foto_tambahan' => isset($filePath) ? $filePath : null,
            'deskripsi_tambahan' => $request->deskripsi_tambahan,
            'id_kategori' => $request->id_kategori,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $tambahan
        ], 201);
    }

    public function update(Request $request, $id_tambahan)
    {
        try {
            // Validasi data
            $request->validate([
                'deskripsi_tambahan' => 'nullable|string',
                'foto_tambahan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'kategori.*' => 'nullable|exists:kategori,id_kategori',
            ]);
    
            // Update deskripsi tambahan
            if ($request->has('deskripsi_tambahan')) {
                $tambahan = Tambahan::findOrFail($id_tambahan);
                $tambahan->deskripsi_tambahan = $request->input('deskripsi_tambahan');
                $tambahan->save();
            }
    
            // Update foto tambahan jika ada
            if ($request->hasFile('foto_tambahan')) {
                foreach ($request->file('foto_tambahan') as $id => $file) {
                    $tambahan = Tambahan::findOrFail($id);
    
                    // Hapus foto lama jika ada
                    if ($tambahan->foto_tambahan && Storage::exists($tambahan->foto_tambahan)) {
                        Storage::delete($tambahan->foto_tambahan);
                    }
    
                    // Simpan foto baru
                    $path = $file->store('produk_tambahan', 'public');
                    $tambahan->foto_tambahan = str_replace('public/', '', $path);
                    $tambahan->save();
                }
            }
    
            // Update kategori tambahan jika ada
            if ($request->has('kategori')) {
                foreach ($request->input('kategori') as $id => $kategoriId) {
                    $tambahan = Tambahan::findOrFail($id);
                    $tambahan->id_kategori = $kategoriId;
                    $tambahan->save();
                }
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }
    
    
    // public function update(Request $request, $id_tambahan)
    // {
    //     try {
    //         // Validasi data
    //         $request->validate([
    //             'deskripsi_tambahan' => 'nullable|string',
    //             'foto_tambahan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //         ]);
    
    //         // Update deskripsi tambahan
    //         if ($request->has('deskripsi_tambahan')) {
    //             // Menggunakan id_tambahan yang diberikan untuk menemukan data tambahan terkait
    //             $tambahan = Tambahan::findOrFail($id_tambahan);
    //             $tambahan->deskripsi_tambahan = $request->input('deskripsi_tambahan');
    //             $tambahan->save();
    //         }
    
    //         // Update foto tambahan jika ada
    //         if ($request->hasFile('foto_tambahan')) {
    //             foreach ($request->file('foto_tambahan') as $id => $file) {
    //                 $tambahan = Tambahan::findOrFail($id);
    
    //                 // Hapus foto lama jika ada
    //                 if ($tambahan->foto_tambahan && Storage::exists($tambahan->foto_tambahan)) {
    //                     Storage::delete($tambahan->foto_tambahan);
    //                 }
    
    //                 // Simpan foto baru
    //                 $path = $file->store('produk_tambahan', 'public');
    //                 $tambahan->foto_tambahan = str_replace('public/', '', $path);
    //                 $tambahan->save();
    //             }
    //         }
    
    //         // Log path foto
    //         Log::info('Updated foto_tambahan path:', ['path' => $tambahan->foto_tambahan]);
    
    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         // Log error untuk debugging
    //         Log::error($e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
    //     }
    // }
    
    
    
    


        public function delete($id_produk)
    {
        // untuk menghapus seluruh data pada tambahan/index.blade.php
        $tambahan = Tambahan::where('id_produk', $id_produk)->get();
        foreach ($tambahan as $item) {
            if (!empty($item->foto_tambahan)) {
                if (Storage::disk('public')->exists($item->foto_tambahan)) {
                    Storage::disk('public')->delete($item->foto_tambahan);
                }
            }
            $item->delete();
        }
        

        // Redirect ke halaman produk show setelah semua data dihapus
        return redirect()->route('admin.produk-show', $id_produk)->with('success', 'Semua data tambahan berhasil dihapus.');
    }


 

    public function destroy($id_produk)
    {
        $tambahan = Tambahan::findOrFail($id_produk);
    
        // Pastikan foto_tambahan tidak null dan tidak kosong
        if (!empty($tambahan->foto_tambahan)) {
            // Hapus foto tambahan dari penyimpanan
            if (Storage::disk('public')->exists($tambahan->foto_tambahan)) {
                Storage::disk('public')->delete($tambahan->foto_tambahan);
            }
        }
    
        $tambahan->foto_tambahan = null; 
        $tambahan->save(); 
        // $tambahan->delete(); 
    
        return redirect()->back()->with('success', 'Data tambahan berhasil dihapus.');
    }
    

    




    
}
