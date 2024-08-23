<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index ()
    {
        // Untuk mengatur produk/index.blade.php

        // $produk = Produk::all();
        // $produk = Produk::orderby('nama_produk')->paginate(5);
        $produk = Produk::paginate(5);
        return view('produk.index',compact('produk'));
    }

   public function store(Request $request)
{
    // untuk store data sama seperti pada kategori controller

    $validatedData = $request->validate([
        // valdiasi inputan dari modal
        'nama' => 'required|string|max:255',
        'id_kategori' => 'required|integer',
        'deskripsi' => 'required|string',
        'link_produk' => 'required|url',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        // untuk size  inputan foto bisa di sesuaikan, itu rio pake 5mb 
    ]);

    $path = $request->file('foto')->store('foto_produk', 'public');
    $url = Storage::url($path);
    // foto nya di simpan di folder_proyek/public/storage/foto_produk/ file-foto 

    $produk = new Produk();
    $produk->nama_produk = $request->nama;
    $produk->id_kategori = $request->id_kategori;
    $produk->deskripsi = $request->deskripsi;
    $produk->link_produk = $request->link_produk;
    $produk->foto_utama = $path;
    $produk->save();

    return response()->json(['success' => 'Produk berhasil ditambahkan!']);
}


public function update(Request $request, $id_produk)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'edit_kategori' => 'required|integer',
        'edit_link_produk' => 'required|url',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048'
    ]);

    // Cari produk berdasarkan parameter 
    $product = Produk::findOrFail($id_produk);

    // Update data 
    $product->nama_produk = $request->input('nama');
    $product->deskripsi = $request->input('deskripsi');
    $product->id_kategori = $request->input('edit_kategori');
    $product->link_produk = $request->input('edit_link_produk');

    // untuk cek ada atau tidak foto baru saat update data produk
    if ($request->hasFile('foto')) {

        // Hapus foto lama jika ada
        if ($product->foto_utama) {
            Storage::delete('public/' . $product->foto_utama);
        }
        
        // Simpan foto yg baru
        $path = $request->file('foto')->store('foto_produk', 'public');
        $product->foto_utama = str_replace('public/', '', $path); 
        
    } else {
        // Jika tidak ada foto baru yang diunggah, gunakan foto yang sudah ada
        $product->foto_utama = $request->input('existing_foto');
    }

    // Simpan perubahan
    $product->save();

    // Redirect ke halaman tadi
    return redirect()->back()->with('success', 'Produk berhasil diupdate.');
}

    public function show ($id_produk)
    {
        // untuk mengatur tampilan produk/detai.blade.php
        // $produk = Produk::findOrFail($id_produk);
        $produk = Produk::with('tambahan')->find($id_produk);
        $fotoTambahanCount = $produk->tambahan->whereNotNull('foto_tambahan')->count();
        $max_foto_tambahan = 4;
        return view('produk.detail', compact('produk', 'fotoTambahanCount','max_foto_tambahan'));
    }

    public function destroy($id_produk)
    {
        // Ini belum rio perbarui method nya, jadi foto yang udah ada pada database sudah terhapus tapi file foto nya masih ada di directory foto_produk
        // Mungkin nanti bisa di perbarui method delete nya, jadi saat hapus data, foto yang di directory juga terhapus. Ntar di copas aja  yang ada di method update di atas
        $produk = Produk::findorfail($id_produk);
        if ($produk->foto_utama && Storage::exists('public/' . $produk->foto_utama)) {
                    Storage::delete('public/' . $produk->foto_utama);
                }
        if ($produk->tambahan->count() > 0) {
            return redirect()->back()->with('error', 'Produk tidak bisa dihapus karena memiliki keterangan tambahan. Harap hapus keterangan tambahan terlebih dahulu.');
        }
       $produk->delete(); 
        return back()->with(['success' => 'Produk berhasil dihapus.']);
    }
    
    public function getAllProducts()
    {
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function getProductDetails($id)
    {
        $produk = Produk::with('kategori')->find($id);

        if ($produk) {
            return response()->json([
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'deskripsi_produk' => $produk->deskripsi,
                'link_produk' => $produk->link_produk,
                'id_kategori' => $produk->id_kategori,
            ]);
        } else {
            return response()->json(['message' => 'Tidak menemukan Produk'], 404);
        }
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('q');
    
        $produk = Produk::with(['kategori', 'tambahan'])
                ->where('nama_produk', 'LIKE', "%$query%")
                ->orderBy('nama_produk')
                ->get()
                ->map(function($item) {
                    return [
                        'id_produk' => $item->id_produk,
                        'nama_produk' => $item->nama_produk,
                        'nama_kategori' => $item->kategori->nama_kategori,  // menampilkan nama kategori
                        'deskripsi_tambahan' => $item->tambahan->first()?->deskripsi_tambahan,  // menampilkan deskripsi tambahan jika ada
                        'kategori_tambahan' => $item->tambahan->first()?->kategori->nama_kategori ?? null,  // menampilkan nama kategori tambahan jika ada
                        'foto_tambahan' => $item->tambahan->first()?->foto_tambahan ?? null,  // menampilkan foto tambahan jika ada
                    ];
                });
    
        return response()->json($produk);
    }
    
    // $query = $request->query('search');
    // $produk = Produk::where('nama_produk', 'LIKE', '%' . $query . '%')->get();
    // return response()->json($produk);

    
}
