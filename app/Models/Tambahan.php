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
    'foto_tambahan', 
    'deskripsi_tambahan', 
    

];
}
