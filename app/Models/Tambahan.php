<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tambahan extends Model
{
    use HasFactory;
    protected $table = 'produk_tambahan';
    protected $primaryKey = 'id_tambahan';
    protected $fillable = [
    'id_produk', 
    'id_kategori', 
    'foto_tambahan', 
    'deskripsi_tambahan', 
];
public function kategori()
{
    return $this->belongsTo(Kategori::class, 'id_kategori');
}
}
