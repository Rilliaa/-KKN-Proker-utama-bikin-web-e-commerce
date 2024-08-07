<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tambahan;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class TambahanController extends Controller
{
    public function index($id_produk)
    {
        // untuk mengatur halaman tambahan/index.blade.php
        $tambahan = Tambahan::where('id_produk', $id_produk)->first();
        $produk = Produk::with('tambahan')->where('id_produk',$id_produk)->first();
        return view('tambahan.index',compact('produk','tambahan'));
        // return view('tambahan.index',compact('produk'));
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

    // public function update(Request $request, $id_tambahan)
    // {
    //     // Validasi file yang diunggah hanya berupa gambar dan deskripsi berupa string
    //     $request->validate([
    //         'foto_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'deskripsi_tambahan.*' => 'nullable|string'
    //     ]);
    
    //     // Gabungkan logika update deskripsi dan foto tambahan
    //     foreach ($request->input('deskripsi_tambahan') as $id => $deskripsi) {
    //         $tambahan = Tambahan::findOrFail($id);
    
    //         // Update deskripsi tambahan jika ada
    //         if (!is_null($deskripsi)) {
    //             $tambahan->deskripsi_tambahan = $deskripsi;
    //         }
    
    //         // Update foto tambahan jika ada file baru yang diunggah untuk ID ini
    //         if ($request->hasFile("foto_tambahan.$id")) {
    //             $file = $request->file("foto_tambahan.$id");
    
    //             // Hapus foto lama jika ada
    //             if ($tambahan->foto_tambahan && Storage::exists('public/' . $tambahan->foto_tambahan)) {
    //                 Storage::delete('public/' . $tambahan->foto_tambahan);
    //             }
    
    //             // Simpan foto baru
    //             $path = $file->store('tambahan', 'public');
    //             $tambahan->foto_tambahan = $path;
    //         }
    
    //         // Simpan perubahan pada masing-masing tambahan
    //         $tambahan->save();
    //     }
    
    //     return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    // }
    
    public function update(Request $request, $id_tambahan)
    {
        $tambahan = Tambahan::findOrFail($id_tambahan);
        
        // Validasi file yang diunggah hanya berupa gambar
        $request->validate([
            'foto_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_tambahan' => 'nullable|string'
        ]);
    
        // Update deskripsi tambahan jika ada
        if ($request->has('deskripsi_tambahan')) {
            $tambahan->deskripsi_tambahan = $request->input('deskripsi_tambahan');
            $tambahan->save();
        }
    
        // Update foto tambahan untuk masing-masing ID tambahan yang dikirim
        if ($request->has('foto_tambahan')) {
            foreach ($request->file('foto_tambahan') as $id => $file) {
                $tambahan = Tambahan::findOrFail($id);
    
                // Hapus foto lama jika ada
                if ($tambahan->foto_tambahan && Storage::exists('public/' . $tambahan->foto_tambahan)) {
                    Storage::delete('public/' . $tambahan->foto_tambahan);
                }
    
                // Simpan foto baru
                $path = $file->store('tambahan', 'public');
                $tambahan->foto_tambahan = $path;
    
                // Simpan perubahan pada masing-masing tambahan
                $tambahan->save();
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

        public function delete($id_produk)
    {
        // untuk menghapus seluruh data pada tambahan/index.blade.php

        // Mengambil semua data tambahan untuk produk ini
        $tambahan = Tambahan::where('id_produk', $id_produk)->get();

        // Menghapus semua foto tambahan dan deskripsi dari database
        foreach ($tambahan as $item) {
            if ($item->foto_tambahan && Storage::exists('public/' . $item->foto_tambahan)) {
                Storage::delete('public/' . $item->foto_tambahan);
            }
            $item->delete();
        }

        // Redirect ke halaman produk show setelah semua data dihapus
        return redirect()->route('admin.produk-show', $id_produk)->with('success', 'Semua data tambahan berhasil dihapus.');
    }


    // public function destroy($id_tambahan)
    // {

    //     // untuk menghapus gambar saja pada tambahan.index
    //     $tambahan = Tambahan::findOrFail($id_tambahan);
    //     // dd("Data",$tambahan);
        
    //     // Hapus foto tambahan dari penyimpanan jika ada
    //     if ($tambahan->foto_tambahan && Storage::exists('public/' . $tambahan->foto_tambahan)) {
    //         Storage::delete('public/' . $tambahan->foto_tambahan);
    //         $tambahan->foto_tambahan = null; // Set foto_tambahan ke null
    //         $tambahan->save(); // Simpan perubahan (hanya menghapus gambar)
    //     }
    
    //     return redirect()->back()->with('success', 'Foto tambahan berhasil dihapus.');
    // }

    public function destroy($id_produk)
    {
        $tambahan = Tambahan::findOrFail($id_produk);
        // Hapus foto tambahan dari penyimpanan
        if ($tambahan->foto_tambahan && Storage::exists('public/' . $tambahan->foto_tambahan)) {
            Storage::delete('public/' . $tambahan->foto_tambahan);
        }
        $tambahan->foto_tambahan = null; 
        $tambahan->save(); 

        return redirect()->back()->with('success', 'Data tambahan berhasil dihapus.');
    }
    




    
}
