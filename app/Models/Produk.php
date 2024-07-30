<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
    'nama_produk', 
    'deskripsi', 
    'link_produk', 
    'id_kategori', 
    'foto_utama', 

];

    public function kategori()
    {
        // relasi dari produk ke kategori
        return $this->belongsTo(Kategori::class,'id_kategori');
    }
}
